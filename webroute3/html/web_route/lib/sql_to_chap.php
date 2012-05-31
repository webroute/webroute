<?php
function sql_to_chap()
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    $select_usr = "SELECT `login`, `password`, `ip` FROM `users`";
    $select_ppp_net = "SELECT `value` FROM `config` where `key`='ppp_network'";
    $result_usr = mysql_query($select_usr);
    
    $result_ppp = mysql_query($select_ppp_net);
    $mass_ppp = mysql_fetch_assoc($result_ppp);
    $ppp_net = $mass_ppp['value'];

    $real = "/etc/lightsquid/realname.cfg";
    $chap = "/etc/ppp/chap-secrets";
    $file = fopen($chap, 'w');
    $file_r  = fopen($real, 'w');

    while($mass_usr = mysql_fetch_assoc($result_usr))
      {
        fwrite($file, $mass_usr['login'] . ' ' . '* ' . $mass_usr['password'] . ' ' . $ppp_net . $mass_usr['ip'] . "\n");
        fwrite($file_r, $ppp_net . $mass_usr['ip']. " " . $mass_usr['login'] . "\n");

      }
    fclose($file);
    fclose($file_r);
    //mysql_close($link);
}
?>