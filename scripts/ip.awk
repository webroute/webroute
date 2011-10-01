(NF==8 && length($1)>=7){
print "insert into webroute.ip (`src_ip`, `dst_ip`, `packets`, `bytes`, `src_port`, `dst_port`, `proto`, `iface`, `stime`) values(inet_aton(\"" \
$1"\"),inet_aton(\"" \
$2"\")," \
$3"," \
$4"," \
$5"," \
$6"," \
$7",\"" \
$8"\",unix_timestamp());"
}