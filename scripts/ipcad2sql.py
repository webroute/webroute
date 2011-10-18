#!/usr/bin/python
import MySQLdb
db= MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
cursor= db.cursor()
tfile = open('/var/traf/tmp', 'r')
a = 0
for line in tfile:
    try:
        cursor.execute(line)
        a = a + 1
    except:
        pass
tfile.close()
print a
