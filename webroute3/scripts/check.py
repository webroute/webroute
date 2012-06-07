#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by crontab every 2 minutes ---#####
####--- version 3.1.0 ---####

import sys
from datetime import date
t = date.today()
sys.path.append('/usr/local/lib/')
from traflib3 import Controller, Base
ctrl = Controller()
ctrl.ipt_reload()
ctrl.l7_filter()
ctrl.check_quota(t.strftime("%Y"), t.strftime("%m"))
