#!/usr/bin/python
import MySQLdb
db= MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
cursor= db.cursor()
tfile = open('/var/traf/tmp', 'r')
for line in tfile:
    cursor.execute(line)
tfile.close()
