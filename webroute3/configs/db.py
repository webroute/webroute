#!/usr/bin/env python
# -*- coding: utf-8 -*-
import MySQLdb
db = MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute', charset='utf8')
cursor = db.cursor()
query4 = "UPDATE `webroute`.`config` SET `value` = '3.1.0' WHERE `config`.`key` = 'version'"
cursor.execute(query4)
