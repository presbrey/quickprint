#!/usr/bin/env python
import cgitb; cgitb.enable()
#print "Content-type: application/ipp\n\n"
#print "Content-type: text/plain\n"
print "Content-type: text/html\n"

import os, sys
from ipplib import IPPRequest

# Parse and print a test file.
#f = file('/tmp/printer.txt','a')
req = IPPRequest(data=file('/tmp/quickprint/test.txt','r').read())
req.parse()
print str(req)
#print req._operation_attributes
#print req._job_attributes
#print getattr(req, '_job_attributes')
#f.write(str(req))
#f.write("\n" + "*"*80 + "\n")
#f.close()
