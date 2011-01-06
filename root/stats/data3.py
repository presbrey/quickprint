#!/usr/bin/python
print "Content-Type: text/plain\r\n\r"

import MySQLdb

con = MySQLdb.connect(read_default_file='/mit/quickprint/.my.cnf')
cur = con.cursor()

q1 = """
SELECT DATE(dadded) as jweek,COUNT(DISTINCT juser) AS jusers
FROM job WHERE DATE(dadded) > "2007-09-01"
GROUP BY WEEK(dadded)
ORDER BY jweek
"""

q1e = cur.execute(q1)
for x in cur.fetchall():
    if x[0] is None: continue
    print ','.join(map(str, x))
