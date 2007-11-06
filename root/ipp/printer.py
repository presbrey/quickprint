#! /usr/bin/env python
import os, sys
try:
    if not os.path.isdir('/tmp/quickprint'):
        os.mkdir('/tmp/quickprint')
except e, Exception:
    pass

import cgi #, cgitb; cgitb.enable(logdir='/tmp/quickprint')
import MySQLdb
from ipplib import IPPRequest
import ipplib

from tempfile import mkstemp
from shutil import move

authfail = False
try:
    argv = cgi.parse(os.environ['QUERY_STRING'])
    webauth = argv['BASIC']
    if type(webauth) is list:
        webauth = webauth[0]
    webauth = webauth.split(' ')[1]
    if not len(webauth):
        authfail = True
    else:
        (authu, authp) = webauth.decode('base64').split(':')
        db=MySQLdb.connect(read_default_file="/mit/quickprint/.my.cnf")
        c = db.cursor()
        c.execute("SELECT 1 FROM auth WHERE auser=%s AND apass=%s LIMIT 1", (authu,authp,))
        if c.fetchone() is None:
            authfail = True
except Exception, e:
    authfail = True

if authfail:
    print "Status: 401 Authorization Required"
    print "WWW-Authenticate: Basic realm=\"QuickPrint\""
    print "Content-type: application/ipp\n"
    #f = file('/tmp/quickprint/printer-auth-fail.txt','a')
    #f.write(str(os.environ) + "\n" + sys.stdin.read() + "\n")
    sys.exit(0)
else:
    AUTH = authu.lower()

print "Content-type: application/ipp\n"

class IPPServer(object):
    def __init__(self):
        pass
    def process(self, request_in, response_out):
        data_in = request_in.read()
        if not len(data_in):
            return
        request = IPPRequest(data=data_in)
        request.parse()

        response = IPPRequest(version=request.version,
                            operation_id=request.operation_id,
                            request_id=request.request_id)
        handler = getattr(self, "_operation_%d" % request.operation_id, None)

        response._operation_attributes = [[]]
        response._operation_attributes[0] = filter( \
            lambda x: x[0] in ('attributes-charset', 'attributes-natural-language', 'printer-uri'),
            request._operation_attributes[0])
#            lambda x: x[0] in ('attributes-charset', 'attributes-natural-language'),
#            request._operation_attributes[0])

        if handler is not None:
            response.setOperationId(handler(request, response))
            data_out = response.dump()
            response_out.write(data_out)
            response_test = IPPRequest(data=data_out)
            response_test.parse()
#            f = file('/tmp/quickprint/printer-in.txt','a')
#            f.write(data_in + "*")
#            #f.close()
#            f.write("\n" + "-"*80 + "\n")
#            f.write(data_out)
#            f.write("\n" + "-"*80 + "\n")
#            f.write(str(request))
#            f.write("\n" + "-"*80 + "\n")
#            f.write(str(response_test))
#            f.write("\n" + "*"*80 + "\n")
#            f.close()
#        else:
#            f = file('/tmp/quickprint/printer.txt','a')
#            #f.write("-"*80 + "\n")
#            f.write(data_in + "\n")
#            f.write(str(request))
#            f.write("*"*80 + "\n")
#            f.close()

    def _operation_2(self, request, response):
        """print-job response"""
        (fno, fname) = mkstemp(dir='/tmp/quickprint')
        os.write(fno, request.data)
        os.close(fno)
        opattr = filter(lambda x: x[0] in ('job-name'),
            request._operation_attributes[0])
        jname = 'unknown'
        if len(opattr) and opattr[0][0] == 'job-name':
            jname = opattr[0][1][0][1]
        jstat = os.stat(fname)
        jsize = jstat.st_size
        c = db.cursor()
        c.execute("INSERT INTO job (juser, jname, jfile, jsize, jtype) VALUES (%s, %s, %s, %s, %s)", \
                (AUTH, jname, fname, jsize, 'PostScript',))
        jid = db.insert_id()
        jfile = '/mit/quickprint/jobs/' + AUTH + '_' + str(jid)
        move(fname, jfile)
        c.execute("UPDATE job SET jfile=%s, dupdated=NOW() WHERE jid=%s", \
                (jfile, str(jid),))
        response._job_attributes = [[ \
            ('job-id', [('integer', 100)]), \
            ('job-uri', [('uri', 'http://quickprint.mit.edu/job/100')]), \
            ('job-state', [('enum', ipplib.IPP_JOB_COMPLETE)])]]
        return ipplib.IPP_OK

    def _operation_10(self, request, response):
        """get-jobs response"""
        return ipplib.IPP_OK

    def _operation_11(self, request, response):
        """get-printer-attributes response"""
        response._printer_attributes = \
            [[('printer-name', [('nameWithoutLanguage', 'QuickPrint')])]]
        return ipplib.IPP_OK

IPPServer().process(sys.stdin,sys.stdout)
