(NF==8 && length($1)>=7){
print "insert into webroute.ip (`src_ip`, `dst_ip`, `packets`, `bytes`, `iface`, `stime`) values(inet_aton(\"" \
$1"\"),inet_aton(\"" \
$2"\")," \
$3"," \
$7",\"" \
$8"\",unix_timestamp());"
}