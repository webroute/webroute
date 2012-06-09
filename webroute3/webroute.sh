#!/bin/bash

## This script mean by default that you have the Scientific Linux 6 
## (not tested but it may work on Centos and RHEL) installed in minimal installation.
## If you want that dhcp work properly you must configure your eth0 interface to 192.168.77.1/24 ip.
## Remove the next 4 lines(begins whith 'exit') and execute this script to begin installation.
## DON'T FORGET chmod +x ./webroute.sh
## For more information about this scrit and system, please visit http://snow-leo.blogspot.com/

exit # Are you disable SELINUX (/etc/selinux/config)?
exit # Are you setup network and have internet connection (/etc/sysconfig/network-scripts)?
exit # Are you turn on ACL (/etc/fstab/)?
exit # Remember that sshd will work on port >>> 12345 <<< and enter username will be >>> aist <<< !!!

##
## If everything is ok, let's start!
##

echo "Starting installation"

echo 'installing packages' >> wbr.log
yum install -y --nogpgcheck ./pkgs/epel-release-6-7.noarch.rpm
yum install -y ppp htop vnstat squid mysql mysql-server httpd php phpmyadmin php-domxml lightsquid lightsquid-apache
yum install -y perl-DBD-MySQL MySQL-python dnsmasq mc setuptool ntsysv screen chkconfig openvpn iptraf-ng lm_sensors smartmontools

if [ `uname -i` = "x86_64" ]; then
    yum install -y --nogpgcheck ./pkgs/64/*.rpm
else
    yum install -y --nogpgcheck ./pkgs/32/*.rpm
fi

echo 'making some useful dirs' >> wbr.log
mkdir /root/backup

echo 'for smartctl' >> wbr.log
chmod 4755 /usr/sbin/smartctl

echo 'for sshd' >> wbr.log
useradd aist
passwd aist
cp -f ./configs/sshd_config /etc/ssh

echo 'for scripts' >> wbr.log
cp -f ./scripts/flow2sql.py /usr/local/bin/
cp -f ./scripts/check.py /usr/local/bin/
cp -f ./scripts/traflib3.py /usr/local/lib/
rm -f /usr/local/lib/*.pyc
chmod +rw /usr/local/lib/*
chmod +rx /usr/local/bin/*

echo 'for sysctrl' >> wbr.log
cp -f ./configs/sysctl.conf /etc/
sysctl -p

echo 'for html' >> wbr.log
cp -rf ./html/* /var/www/html/

cat ./configs/cron >> /var/spool/cron/root

echo 'for iptables' >> wbr.log
cp -f ./configs/iptables /etc/sysconfig/iptables
cp -f ./configs/iptables-config /etc/sysconfig/

echo 'for dnsmasq' >> wbr.log
cp -f ./configs/dnsmasq.conf /etc/dnsmasq.conf

echo 'for vnstat' >> wbr.log
vnstat -u -i eth1

echo 'for squid' >> wbr.log
cp -f ./configs/squid.conf /etc/squid/
chown -R 777 /etc/squid/banlist/

echo 'for flow-capture' >> wbr.log
cp -f ./configs/flow-capture /etc/sysconfig/

echo 'for ipt-netflow' >> wbr.log
cp -f ./configs/ipt-netflow.conf /etc/modprobe.d/

echo 'for hosts' >> wbr.log
cp -f ./configs/hosts /etc/

echo 'for sudoers' >> wbr.log
cp -f ./configs/sudoers /etc/

echo 'for lightsquid' >> wbr.log
cp -f ./lightsquid/lightsquid.cfg /etc/lightsquid
cp -rf ./lightsquid/exmpl/* /var/lightsquid
touch /etc/lightsquid/skipuser.cfg
touch /etc/lightsquid/realname.cfg

echo 'for ppp' >> wbr.log
cp -f ./ppp/ip-up.local /etc/ppp
cp -f ./ppp/ip-down.local /etc/ppp

echo 'for mysql' >> wbr.log
service mysqld start
service mysqld stop
cp -rf ./mysql/webroute/ /var/lib/mysql/
chown -R mysql:mysql /var/lib/mysql/
service mysqld start
echo "grant all on webroute.* to webroute@localhost identified by 'wbr';" | mysql -u root
mysql_secure_installation

echo "seting ACL's" >> wbr.log
setfacl -m u:apache:rwx /etc/lightsquid/
setfacl -m u:apache:rwx /etc/ppp/
setfacl -m u:apache:rwx /etc/squid/
setfacl -m u:apache:rwx /etc/ppp/chap-secrets
setfacl -m u:apache:rwx /etc/squid/banlist/
setfacl -m u:apache:rwx /etc/squid/redirector.conf
setfacl -m u:apache:rwx /etc/lightsquid/lightsquid.cfg
setfacl -m u:apache:rwx /etc/lightsquid/realname.cfg
setfacl -m u:apache:rwx /etc/lightsquid/skipuser.cfg
setfacl -m u:apache:rwx /etc/l7-filter.conf
mkdir /etc/squid/banlist/usr/2
mkdir /etc/squid/banlist/den/2
chmod -R 777 /etc/squid/banlist/

mv -f ./pkgs/lists.zip /tmp/
/usr/bin/python ./configs/dl_blacklists.py
/usr/bin/python ./configs/db.py

echo 'checking services at startup' >> wbr.log
chkconfig crond on
chkconfig lm_sensors on
chkconfig smartd on
chkconfig auditd off
chkconfig pppoe-server on
chkconfig pptpd on
chkconfig httpd on
chkconfig mysqld on
chkconfig squid on
chkconfig dnsmasq on
chkconfig iptables on
chkconfig ip6tables off
chkconfig netfs off
chkconfig vnstat on
chkconfig sshd on
chkconfig pptpd on
chkconfig flow-capture on
echo 'l7-filter -f /etc/l7-filter.conf -z' >> /etc/rc.local
echo 'detecting sensors' >> wbr.log
sensors-detect

echo 'Updating system' >> wbr.log
yum update -y

echo 'All done! Press enter to reboot machine'
read

echo 'Machine will be rebooted in 5 seconds'
sleep 5
reboot

