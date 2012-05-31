#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by flow-export programm ---#####

import sys, os
from datetime import date
sys.path.append('/usr/local/lib/')
from traflib3 import Controller
file = sys.argv[1]
file_path = "/var/flow-tools/"+file
os.system("""/usr/bin/flow-export -f3 -m DOCTETS,SRCADDR,DSTADDR -u "webroute:wbr:localhost:3306:webroute:ip" < """ + file_path)
os.remove(file_path)
ctrl = Controller()
ctrl.ipt_reload()
t = date.today()
ctrl.agregate()
ctrl.check_quota(t.strftime("%Y"), t.strftime("%m"))
