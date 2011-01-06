#!/usr/bin/python
print "Content-Type: text/plain\r\n\r"
import sys
sys.path.insert(0, '/afs/sipb.mit.edu/project/quickprint/lib/python')

import MySQLdb

con = MySQLdb.connect(read_default_file='/mit/quickprint/.my.cnf')
cur = con.cursor()

q1 = """
SELECT jday, COUNT(*) AS njobs FROM
  (SELECT dupdated,DATE(dupdated) as jday FROM job j
   WHERE jstatus LIKE 'Printed to%'
   AND DATE(dadded) > "2007-09-01") AS t2
  GROUP BY jday;
"""

#q1 = """
#SELECT DATE(dupdated) as jweek,COUNT(*) AS njobs
#FROM job WHERE DATE(dadded) > "2007-09-01" AND jstatus LIKE 'Printed to%'
#GROUP BY WEEK(dupdated)
#ORDER BY jweek
#"""

q1e = cur.execute(q1)
for x in cur.fetchall():
    if x[0] is None: continue
    print ','.join(map(str, x))
