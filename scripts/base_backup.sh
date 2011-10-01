#!/bin/bash

mysqldump -uroot -pzvercd123 webroute | gzip -c > /root/backup/wbr`date "+%Y-%m-%d"`.gz
find /root/backup -name "*.gz" -mtime +30 -exec rm -f {} \;