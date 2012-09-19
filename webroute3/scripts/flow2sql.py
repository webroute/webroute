#!/usr/bin/env python
# -*- coding: utf-8 -*-
####--- start by flow-export every 2 minutes ---#####
####--- version 3.1.3 ---####

import sys, os
sys.path.append('/usr/local/lib/')
from traflib3 import Controller
file = sys.argv[1]
file_path = "/var/flow-tools/"+file
os.system("""/usr/bin/flow-export -f3 -m DOCTETS,SRCADDR,DSTADDR -u "webroute:wbr:localhost:3306:webroute:ip" < """ + file_path)
os.remove(file_path)
ctrl = Controller()
ctrl.agregate()
