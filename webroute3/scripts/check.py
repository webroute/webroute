#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by cron every 2 minutes ---#####
####--- version 3.2.1 ---####

import sys
from datetime import date, datetime
now = datetime.now()
t = date.today()
sys.path.append('/usr/local/lib/')
from traflib3 import Controller, Base

ctrl = Controller()
ctrl.ipt_reload()
ctrl.l7_filter()
ctrl.check_quota(t.strftime("%Y"), t.strftime("%m"))

if now.hour == 23 and now.minute + 2 >= 60:
    base = Base()
    today = str(date.today())
    ctrl.final_stat(today)
    base.backup()
    base.clean_db()
    base.clean_netflow_trash()
    
#    if now.month == 6 and now.day == 30:
#        lastyear = now.year - 1
#        base.archive(lastyear)
