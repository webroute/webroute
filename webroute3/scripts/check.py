#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by crontab every 2 minutes ---#####
####--- version 3.1.0 ---####

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
    if t.strftime('%m') == 06 and t.strftime('%d') == 30:
        now = datetime.now()
        lastyear = now.year - 1
        base.archive(lastyear)
