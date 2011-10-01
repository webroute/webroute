<?php
//#!/usr/bin/php
$db_host = 'localhost';
$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());
mysql_set_charset('utf8',$link);

$tmp_f = '/var/traf/tmp';

$lines = file($tmp_f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

//$ppp_net = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'ppp_network'";
//$quer2 = mysql_fetch_assoc(mysql_query($ppp_net));
//$ppp = $quer2['value'];

//$select_ip = "SELECT `ip`, `login` FROM `users`";
//$sel_ip = mysql_query($select_ip);

foreach ($lines as $line_num => $line)
{
        $ins = $line;
        mysql_query($ins) or die (mysql_error());
}

/*
while ($q = mysql_fetch_assoc($sel_ip))
{

    $login = $q['login'];
    $ip = $ppp . $q['ip'];
    //echo $ip . '<br>';
    $nul = "INSERT INTO `tmp_traf` (`src_ip`,`dst_ip`,`bs`) VALUES ('$ip','$ip','0')";

    $tmp_s_out = "SELECT `bs` FROM `tmp_traf` WHERE `src_ip`='$ip'";
    $tmp_s_out = mysql_query($tmp_s_out);

    $tmp_s_in = "SELECT `bs` FROM `tmp_traf` WHERE `dst_ip`='$ip'";
    $tmp_s_in = mysql_query($tmp_s_in);

    $bs_out = 0;
    while($qa = mysql_fetch_assoc($tmp_s_out))
    {
        $bs_out = $bs_out + $qa['bs'];
    }
    //echo $bs_out . '<br>';

    $bs_in = 0;
    while($qa = mysql_fetch_assoc($tmp_s_in))
    {
        $bs_in = $bs_in + $qa['bs'];
    }
    //echo $bs_in . '<br><br>';

    $quer = "INSERT INTO `traf` (`date`,`ip`, `login`, `in`, `out`) VALUES ('$date','$ip','$login','$bs_in','$bs_out')";
    mysql_query($quer);
    
}





$turn = "TRUNCATE TABLE `tmp_traf`";
mysql_query($turn);
*/
?>
