#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by flow-export every 2 minutes ---#####
####--- version 3.1.0 ---####

import sys, os
from datetime import date, datetime
now = datetime.now()
t = date.today()
sys.path.append('/usr/local/lib/')
from traflib3 import Controller, Base
file = sys.argv[1]
file_path = "/var/flow-tools/"+file
os.system("""/usr/bin/flow-export -f3 -m DOCTETS,SRCADDR,DSTADDR -u "webroute:wbr:localhost:3306:webroute:ip" < """ + file_path)
os.remove(file_path)
ctrl = Controller()
ctrl.ipt_reload()
ctrl.l7_filter()
t = date.today()
ctrl.agregate()
ctrl.check_quota(t.strftime("%Y"), t.strftime("%m"))
if now.hour == 23 and now.minute + 2 >= 60:
    base = Base()
    today = str(date.today())
    ctrl.final_stat(today)
    base.backup()
    if t.strftime('%m') == 06 and t.strftime('%d') == 30:
        now = datetime.now()
        lastyear = now.year - 1
        base.archive(lastyear)
