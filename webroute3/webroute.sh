#!/bin/bash

############################# installer version 2.0 #######################
#====================== IN ENGLISH ==========================================
## This script mean by default that you have the Scientific Linux or CentOS version 6
## (not tested but it may work on Oracle Linux and RHEL) installed in minimal installation.
## If you want that dhcp work properly you must configure your eth0 interface to 192.168.77.1/24 ip.
## Remove the next 3 lines(begins whith 'exit') and execute this script to begin installation.
## DON'T FORGET chmod +x ./webroute.sh
## For more information about this scrit and system, please visit http://snow-leo.blogspot.com/ or http://webroute.org
## ATTENTION!!! Note that after installation, from the Internet, will be available SSH port.
## So you must set a long and complicated password or better to ban all password authentication
## and configure authentication by keys.
## Information on how to do this can be found here: http://snow-leo.blogspot.com/2012/09/sshd.html
#====================== ПО РУССКИ ===========================================
## По умолчанию подразумевается что у Вас Scientific Linux или CentOS шестой версии в минимально возможной инсталяции
## (не тестировалось но должно работать и на Oracle Linux и на RHEL).
## Если Вы хотите чтобы у Вас работал DHCP то рекомендуется настроить на интерфейсе eth0 адресс 192.168.77.1/24
## Удалите 3 строки начинающихся с 'exit' и выполните скрипт для начала установки
## Не забудьте команду chmod +x ./webroute.sh
## Для получения доплнительных сведений обращайтесь по адресу: http://snow-leo.blogspot.com/ или http://webroute.org
## ВНИМАНИЕ!!! Учтите, что после инсталяции, из сети интернет, будет доступен SSH порт.
## Поэтому Вам лучше установить пароль по длинее и по сложнее, а еще лучше запретить вообще аутентификацию по паролю
## и настроить аутентификацию по ключам. О том как это сделать, можно почитать здесь: http://snow-leo.blogspot.com/2012/09/sshd.html
## +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
## Небольшое примечание: в комплекте с установочными скриптами идут блэк листы, как Вы наверно уже заметили,
## они устарели, да и плюс ко всему они специально прорежены (в комплекте ровно по половине от каждого из оригинальных списков).
## Для получения оригинальных(полных и свежих) блэк листов необходимы регистрация и участие в системе DBL.
## За подробностями обращайтесь по адресу: http://rejik.ru/index_ru_8_1.html
## Также рекомендую посмотреть http://snow-leo.blogspot.com/2012/05/blog-post_31.html
###############################################################################

exit 0 # Are you disable SELINUX (/etc/selinux/config)?
exit 0 # Are you setup network and have internet connection (/etc/sysconfig/network-scripts/)?
exit 0 # Are you turn on ACL (/etc/fstab)?

echo "Starting installation"

echo 'installing packages' >> /root/webroute_install.log
yum install -y --nogpgcheck ./pkgs/epel-release-6-7.noarch.rpm
yum install -y ppp htop vnstat squid mysql mysql-server httpd php phpmyadmin php-domxml lightsquid lightsquid-apache
yum install -y perl-DBD-MySQL MySQL-python dnsmasq mc setuptool ntsysv screen chkconfig openvpn iptraf-ng lm_sensors smartmontools

if [ `uname -i` = "x86_64" ]; then
    yum install -y --nogpgcheck ./pkgs/64/*.rpm
else
    yum install -y --nogpgcheck ./pkgs/32/*.rpm
fi

echo 'Updating system' >> /root/webroute_install.log
yum update -y

echo 'making some useful dirs' >> /root/webroute_install.log
mkdir /root/backup

echo 'setup smartctl' >> /root/webroute_install.log
chmod 4755 /usr/sbin/smartctl

echo 'setup scripts' >> /root/webroute_install.log
cp -f ./scripts/flow2sql.py /usr/local/bin/
cp -f ./scripts/check.py /usr/local/bin/
cp -f ./scripts/traflib3.py /usr/local/lib/
rm -f /usr/local/lib/*.pyc
chmod +rw /usr/local/lib/*
chmod +rx /usr/local/bin/*

echo 'setup sysctrl' >> /root/webroute_install.log
cp -f ./configs/sysctl.conf /etc/
sysctl -p

echo 'setup html' >> /root/webroute_install.log
cp -rf ./html/* /var/www/html/

cp -f ./configs/webroute /etc/cron.d/

echo 'setup iptables' >> /root/webroute_install.log
cp -f ./configs/iptables /etc/sysconfig/iptables
cp -f ./configs/iptables-config /etc/sysconfig/

echo 'setup dnsmasq' >> /root/webroute_install.log
cp -f ./configs/dnsmasq.conf /etc/dnsmasq.conf

echo 'setup vnstat' >> /root/webroute_install.log
vnstat -u -i eth1

echo 'setup squid' >> /root/webroute_install.log
cp -f ./configs/squid.conf /etc/squid/
chown -R 777 /etc/squid/banlist/

echo 'setup flow-capture' >> /root/webroute_install.log
cp -f ./configs/flow-capture /etc/sysconfig/

echo 'setup ipt-netflow' >> /root/webroute_install.log
cp -f ./configs/ipt-netflow.conf /etc/modprobe.d/

echo 'setup hosts' >> /root/webroute_install.log
cp -f ./configs/hosts /etc/

echo 'setup sudoers' >> /root/webroute_install.log
cp -f ./configs/sudoers /etc/

echo 'setup lightsquid' >> /root/webroute_install.log
cp -f ./lightsquid/lightsquid.cfg /etc/lightsquid
cp -rf ./lightsquid/exmpl/* /var/lightsquid
cp -rf ./lightsquid/tpl /usr/share/lightsquid/
touch /etc/lightsquid/skipuser.cfg
touch /etc/lightsquid/realname.cfg

echo 'setup ppp scripts' >> /root/webroute_install.log
cp -f ./scripts/ip-up.local /etc/ppp
cp -f ./scripts/ip-down.local /etc/ppp
chmod +x /etc/ppp/*.local

echo 'setup mysql' >> /root/webroute_install.log
service mysqld start
echo "create database webroute;" | mysql -u root
mysql -u root -D webroute < ./configs/webroute.sql
echo "grant all on webroute.* to webroute@localhost identified by 'wbr';" | mysql -u root
echo "UPDATE mysql.user SET Password=PASSWORD('zvercd123') WHERE User='root';" | mysql -u root
echo "DROP DATABASE test;" | mysql -u root
echo "DELETE FROM mysql.user WHERE User='';" | mysql -u root
echo "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');" | mysql -u root
echo "FLUSH PRIVILEGES;" | mysql -u root

echo "seting ACL's" >> /root/webroute_install.log
cp -f ./configs/redirector.conf /etc/squid/
cp -f ./configs/chap-secrets /etc/ppp/
cp -f ./configs/realname.cfg /etc/lightsquid/
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

echo "making squid dirs" >> /root/webroute_install.log
mkdir -p /etc/squid/banlist/usr/1
mkdir -p /etc/squid/banlist/den/1
mkdir -p /etc/squid/banlist/lock_file
chmod -R 777 /etc/squid/banlist/

mv -f ./pkgs/lists.zip /tmp/
/usr/bin/python ./configs/dl_blacklists.py

echo 'checking services at startup' >> /root/webroute_install.log

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

echo 'All done! Machine will be rebooted in 5 seconds'
echo '5...'
sleep 1
echo '4...'
sleep 1
echo '3...'
sleep 1
echo '2...'
sleep 1
echo '1...'
sleep 1
reboot
