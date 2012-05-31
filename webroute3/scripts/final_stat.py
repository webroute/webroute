#!/usr/bin/env python
# -*- coding: utf-8 -*-
######--- start at 23:59 everyday ---#######

import sys
from datetime import date, datetime
sys.path.append('/usr/local/lib/')
from traflib3 import Controller, Base
t = date.today()
ctrl = Controller()
base = Base()
today = str(date.today())
ctrl.final_stat(today)
base.backup()
######--- If it is last day of june, archive database ---######
if t.strftime('%m') == 06 and t.strftime('%d') == 30:
    now = datetime.now()
    lastyear = now.year - 1
    base.archive(lastyear)
