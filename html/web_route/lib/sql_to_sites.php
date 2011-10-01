<?php
function sql_to_sites($change)
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);

    $allow_q = "SELECT `value` FROM `config` WHERE `key`='rej_allow_urls'";
    $allow_f = mysql_fetch_assoc(mysql_query($allow_q));
    $allow_f = $allow_f['value'];

    $deny_q = "SELECT `value` FROM `config` WHERE `key`='rej_ban_pref'";
    $deny_f = mysql_fetch_assoc(mysql_query($deny_q));
    $deny_f = $deny_f['value'] . "quick_ban/urls";

    if($change == "allow")
    {
        $sel = "SELECT `site` FROM `site_allow`";
        $file = $allow_f;
    }
    else
    {
        $sel = "SELECT `site` FROM `site_deny`";
        $file = $deny_f;
    }
    
    $file = fopen($file, 'w');
    $sel_site = mysql_query($sel);
    while ($sites = mysql_fetch_assoc($sel_site))
    {
        fwrite($file, $sites['site']);
        fwrite($file, "\n");
    }
    fclose($file);
    exec('sudo squid -k reconfigure');
}
?>
