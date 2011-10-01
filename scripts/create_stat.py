#!/usr/bin/env python
import MySQLdb
from datetime import date
db= MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
cursor= db.cursor()
cur_date = date.today()
cur_date = str(cur_date)
ppp_net = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'ppp_network'"
cursor.execute(ppp_net)
ppp = cursor.fetchone()
ppp = ppp[0]
select_ip = "SELECT `ip`, `login` FROM `users`"
cursor.execute(select_ip)
ip = cursor.fetchall()
for record in ip:
    login = str(record[1])
    ip2 = str(record[0])
    
    null = "insert into webroute.ip (`src_ip`, `dst_ip`, `packets`, `bytes`, `src_port`, `dst_port`, `proto`, `iface`, `stime`) values (inet_aton('" + ppp + ip2 + "'),inet_aton('" + ppp + ip2 + "'),0,0,0,0,0,'ppp0',unix_timestamp())"
    cursor.execute(null)
    
    tmp_s_out = "select sum(bytes) from ip where inet_ntoa(src_ip)='" + ppp + ip2 + "'"
    cursor.execute(tmp_s_out)
    bs_out = cursor.fetchone()
    bs_out = str (bs_out[0])
    
    tmp_s_in = "select sum(bytes) from ip where inet_ntoa(dst_ip)='" + ppp + ip2 + "'"
    cursor.execute(tmp_s_in)
    bs_in = cursor.fetchone()
    bs_in = str(bs_in[0])

    quer = "INSERT INTO `traf` (`date`,`ip`, `login`, `in`, `out`) VALUES ('" + cur_date + "','" + ppp + ip2 + "','" + login + "','" + bs_in + "','" + bs_out + "')"
    cursor.execute(quer)
    
turn = "TRUNCATE TABLE `ip`"
cursor.execute(turn)
