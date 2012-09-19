#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- version 3.2.2 ---####

import os, MySQLdb
from datetime import date
from time import strftime

class Controller(object):
    def __init__(self):
        self.cur_hour    = int(strftime("%H"))
        self.cur_min     = int(strftime("%M"))
        t                = date.today()
        self.cur_day     = t.strftime("%d")
        self.cur_month   = t.strftime("%m")
        self.cur_year    = t.strftime("%Y")
        self.cur_date    = str(date.today())
        self.ppp_net     = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'ppp_network'"
        self.select_ip   = "SELECT `ip`, `login` FROM `users`"
        db               = MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
        self.cursor      = db.cursor()

    def agregate(self):
        self.cursor.execute(self.ppp_net)
        ppp = self.cursor.fetchone()
        ppp = ppp[0]
        self.cursor.execute(self.select_ip)
        ip = self.cursor.fetchall()
        for record in ip:
            login = str(record[1])
            ip2 = str(record[0])
            nul = "insert into webroute.ip (`SRCADDR`, `DSTADDR`, `DOCTETS`) values ('" + ppp + ip2 + "','" + ppp + ip2 + "',0)"
            self.cursor.execute(nul)

            tmp_s_out = "select sum(`DOCTETS`) from ip where `SRCADDR`='" + ppp + ip2 + "'"
            self.cursor.execute(tmp_s_out)
            bs_out = self.cursor.fetchone()
            bs_out = str(bs_out[0])

            tmp_s_in = "select sum(`DOCTETS`) from ip where `DSTADDR`='" + ppp + ip2 + "'"
            self.cursor.execute(tmp_s_in)
            bs_in = self.cursor.fetchone()
            bs_in = str(bs_in[0])

            quer = "INSERT INTO `ip_temp` (`ip`, `login`, `in`, `out`) VALUES ('" + ppp + ip2 + "','" + login + "','" + bs_in + "','" + bs_out + "')"
            self.cursor.execute(quer)

        turn = "TRUNCATE TABLE `ip`"
        self.cursor.execute(turn)

    def final_stat(self, date):
        self.cursor.execute(self.ppp_net)
        ppp = self.cursor.fetchone()
        ppp = ppp[0]
        self.cursor.execute(self.select_ip)
        ip = self.cursor.fetchall()
        for record in ip:
            login = str(record[1])
            ip2 = str(record[0])

            tmp_s_out = "select sum(`out`) from ip_temp where login='" + login + "'"
            self.cursor.execute(tmp_s_out)
            bs_out = self.cursor.fetchone()
            bs_out = str (bs_out[0])

            tmp_s_in = "select sum(`in`) from ip_temp where login='" + login + "'"
            self.cursor.execute(tmp_s_in)
            bs_in = self.cursor.fetchone()
            bs_in = str(bs_in[0])

            quer = "INSERT INTO `traf` (`date`,`ip`, `login`, `in`, `out`) VALUES ('" + date + "','" + ppp + ip2 + "','" + login + "','" + bs_in + "','" + bs_out + "')"
            self.cursor.execute(quer)

        turn_temp = "TRUNCATE TABLE `ip_temp`"
        self.cursor.execute(turn_temp)

    def ipt_reload(self):
        query_select = "SELECT `ip` FROM `quota` WHERE `blocked` = '1'"
        self.cursor.execute(query_select)
        select = self.cursor.fetchall()
        os.system('/sbin/iptables -t filter -F QUOTA')
        if select:
            for rec in select:
                adr = rec[0]
                rule_s = '/sbin/iptables -t filter -A QUOTA -s '+ adr + ' -j DROP'
                rule_d = '/sbin/iptables -t filter -A QUOTA -d '+ adr + ' -j DROP'
                os.system(rule_d)
                os.system(rule_s)

    def block_ip(self, adr, reas):
        query_drop =  "UPDATE  `webroute`.`quota` SET  `reason` ='" + reas + "' WHERE  `quota`.`ip` ='" + adr +"'"
        query_block = "UPDATE  `webroute`.`quota` SET  `blocked` =  '1' WHERE  `quota`.`ip` ='" + adr +"'"
        self.cursor.execute(query_drop)
        self.cursor.execute(query_block)
        self.ipt_reload()

    def pass_ip(self, adr):
        query_pass = "UPDATE  `webroute`.`quota` SET  `reason` ='---' WHERE  `quota`.`ip` ='" + adr +"'"
        query_unblock = "UPDATE  `webroute`.`quota` SET  `blocked` = '0' WHERE  `quota`.`ip` ='" + adr +"'"
        self.cursor.execute(query_pass)
        self.cursor.execute(query_unblock)
        self.ipt_reload()

    def check_quota(self, cyear, cmonth):
        sel_rec = "SELECT `id`, `login`, `ip`, `blocked` FROM `quota`"
        reload_ipt = 0
        self.cursor.execute(sel_rec)
        rec = self.cursor.fetchall()
        for inst in rec:
            login = inst[1]
            ip= inst[2]
            blocked = int(inst[3])
            #counting quota for our record
            sel_quota = "SELECT sum(`in_quota_d`), sum(`out_quota_d`), sum(`in_quota_m`), sum(`out_quota_m`) FROM `quota` WHERE `login`='" + login + "'"
            self.cursor.execute(sel_quota)
            quota_view = self.cursor.fetchall()
            for record in quota_view:
                in_quota_d  = int(record[0])
                out_quota_d = int(record[1])
                in_quota_m  = int(record[2])
                out_quota_m = int(record[3])
                if login != None:
                    #counting month trafic for record
                    month_traf   = "SELECT `login`, sum(`in`), sum(`out`), `ip` FROM `traf` WHERE `date` LIKE '" + cyear + "-" + cmonth + "%' AND `ip`='" + ip + "'"
                    self.cursor.execute(month_traf)
                    bs = self.cursor.fetchone()
                    month_traf_in  = 1
                    month_traf_out = 1
                    if bs[1] != None:month_traf_in  = int(bs[1])
                    if bs[2] != None:month_traf_out = int(bs[2])
                    #counting day trafic for record
                    day_traf_in  = "SELECT sum(`in`) from ip_temp where login='" + login + "'"
                    day_traf_out = "SELECT sum(`out`) from ip_temp where login='" + login + "'"
                    self.cursor.execute(day_traf_in)
                    day_in = self.cursor.fetchone()
                    self.cursor.execute(day_traf_out)
                    day_out = self.cursor.fetchone()
                    day_traf_in  = 1
                    day_traf_out = 1
                    if day_in[0] != None:day_traf_in  = int(day_in[0])
                    if day_out[0] != None:day_traf_out = int(day_out[0])
                    #checking whats the quota for record, 0 == infinite
                    in_quota_d2 = in_quota_d
                    in_quota_m2 = in_quota_m
                    out_quota_d2 = out_quota_d
                    out_quota_m2 = out_quota_m
                    if in_quota_d  == 0:in_quota_d2  = day_traf_in + 999
                    if out_quota_d == 0:out_quota_d2 = day_traf_out + 999
                    if in_quota_m  == 0:in_quota_m2  = month_traf_in + 999
                    if out_quota_m == 0:out_quota_m2 = month_traf_out + 999

                    if int(in_quota_m) != 0 and month_traf_in + day_traf_in >= in_quota_m2 and blocked == 0:
                        print('m_in')
                        reason = "month_in"
                        self.block_ip(ip,reason)
                        reload_ipt = 1
                    elif int(out_quota_m) != 0 and month_traf_out + day_traf_out >= out_quota_m2 and blocked == 0:
                        print('m_o')
                        reason = "month_out"
                        self.block_ip(ip,reason)
                        reload_ipt = 1
                    elif int(in_quota_d) != 0 and day_traf_in >= in_quota_d2 and blocked == 0:
                        print('d_i')
                        reason = "day_in"
                        self.block_ip(ip,reason)
                        reload_ipt = 1
                    elif int(out_quota_d) != 0 and day_traf_out >= out_quota_d2 and blocked == 0:
                        print('d_o')
                        reason = "day_out"
                        self.block_ip(ip,reason)
                        reload_ipt = 1
                    elif ((day_traf_in < in_quota_d) or (day_traf_out < out_quota_d)) and ((month_traf_in + day_traf_in < in_quota_m) or (month_traf_out + day_traf_out < out_quota_m)) and blocked == 1:
                        self.pass_ip(ip)
                        reload_ipt = 1
                    else:
                        self.ipt_reload()
                        reload_ipt = 1
                else:
                    if reload_ipt == 0:
                        self.ipt_reload()
                        reload_ipt = 1
        if reload_ipt == 0: self.ipt_reload()

    def l7_filter(self):
        query_select = "SELECT `ip`, `proto_code` FROM `l7filter`"
        self.cursor.execute(query_select)
        select = self.cursor.fetchall()
        os.system('/sbin/iptables -t filter -F l7filter')
        if select:
            for rec in select:
                self.cursor.execute(self.ppp_net)
                ppp = self.cursor.fetchone()
                ppp = ppp[0]
                adr    = ppp + str(rec[0])
                proto  = rec[1]
                rule_s = '/sbin/iptables -t filter -A l7filter -s '+ adr +' -m mark --mark '+ proto +' -j DROP'
                rule_d = '/sbin/iptables -t filter -A l7filter -d '+ adr +' -m mark --mark '+ proto +' -j DROP'
                os.system(rule_d)
                os.system(rule_s)

class Base(object):
    def __init__(self):
        self.dump = """/usr/bin/mysqldump -uroot -pzvercd123 webroute | /bin/gzip -c > /root/backup/wbr`date "+%Y-%m-%d"`.gz"""
        self.find = """/bin/find /root/backup -name "*.gz" -mtime +10 -exec /bin/rm -f {} \;"""
        self.last_year_dump = """/usr/bin/mysqldump -uroot -pzvercd123 webroute | /bin/gzip -c > /root/backup/last_year_traffic-`date '+%Y-%m-%d'`.gzip"""

    def backup(self):
        os.system(self.dump)
        os.system(self.find)

    def archive(self, last_year):
        os.system(self.last_year_dump)
        db = MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
        cursor = db.cursor()
        rem_last_year = "DELETE FROM `traf` WHERE `date` LIKE '"+ last_year +"%'"
        cursor.execute(rem_last_year)

    def clean_db(self):
        db = MySQLdb.connect(host='localhost', user='webroute', passwd='wbr', db='webroute')
        cursor = db.cursor()
        rem_zero = """DELETE FROM `traf` WHERE `in`='0' AND `out`='0'"""
        optimize_tables ="""OPTIMIZE TABLE `config`, `conn_speed`, `ip_temp`, `l7filter`, `l7protocols`, `quota`, `rej_abs_exc`, `rej_categories`, `rej_exc`, `rej_usr_exc`, `report_except`, `sites`, `speed`, `traf`, `users` """
        cursor.execute(rem_zero)
        cursor.execute(optimize_tables)

    def clean_netflow_trash(self):
        find_trash = """/bin/find /var/flow-tools -name "*" -mmin +5 -exec /bin/rm -f {} \;"""
        os.system(find_trash)

