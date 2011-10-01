#!/bin/sh

echo "" > /var/traf/tmp
/usr/bin/rsh localhost dump &> /dev/null
/bin/awk -f /root/scripts/ip.awk /var/log/ipcad/ipcad.dump > /var/traf/tmp
/usr/bin/rsh localhost clear ip acco &> /dev/nul
/root/scripts/ipcad2sql.py
echo "" > /var/traf/tmp
