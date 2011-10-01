<?php
function sql_to_redirector()
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);

    //selecting all enabled categories
    $select_cat = "SELECT `name` FROM `webroute`.`rej_categories` WHERE `enabled`=1";
    //selecting absolute exceptions for users
    $select_abs_exc = "SELECT * FROM `rej_abs_exc`";
    //selecting ppp network
    $ppp_net = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'ppp_network'";
    //selecting the destination of the error.log
    $rej_error_log = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_error_log'";
    //selecting the destination of the change.log
    $rej_change_log = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_change_log'";
    //selecting the destination of the make-cache
    $rej_make_cache = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_make-cache'";
    //selecting the destination of the allow urls file
    $rej_allow_urls = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_allow_urls'";
    //selecting the destination of the banlist directory
    $rej_ban_pref = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_ban_pref'";
    //selecting the ban url
    $rej_ban_url = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_ban_url'";
    //selecting the destination of the redirector.conf
    $redirector = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_redir_conf'";

    $quer1 = mysql_fetch_assoc(mysql_query($redirector));
    $redir = $quer1['value'];
    $quer2 = mysql_fetch_assoc(mysql_query($ppp_net));
    $ppp = $quer2['value'];
    $sel_abs_exc = mysql_query($select_abs_exc);
    $quer4 = mysql_fetch_assoc(mysql_query($rej_error_log));
    $quer5 = mysql_fetch_assoc(mysql_query($rej_change_log));
    $quer6 = mysql_fetch_assoc(mysql_query($rej_make_cache));
    $quer7 = mysql_fetch_assoc(mysql_query($rej_allow_urls));
    $quer8 = mysql_fetch_assoc(mysql_query($rej_ban_pref));
    $quer9 = mysql_fetch_assoc(mysql_query($rej_ban_url));
    
    $file = fopen($redir, 'w');

    fwrite($file, "work_ip ");
    fwrite($file, $ppp . "0/24\n");

        while($quer3 = mysql_fetch_assoc($sel_abs_exc))
        {
            fwrite($file, "allow_ip ");
            fwrite($file, $ppp . $quer3['usr_ip']);
            fwrite($file, "\n");
        }

    fwrite($file, "error_log ");
    fwrite($file, $quer4['value']);
    fwrite($file, "\n");
    fwrite($file, "change_log ");
    fwrite($file, $quer5['value']);
    fwrite($file, "\n");
    fwrite($file, "make-cache ");
    fwrite($file, $quer6['value']);
    fwrite($file, "\n");
    fwrite($file, "allow_urls ");
    fwrite($file, $quer7['value']);
    fwrite($file, "\n\n");

    $se_cat = mysql_query($select_cat);
    while ($cat = mysql_fetch_assoc($se_cat))
    {
        fwrite($file, "<");
        fwrite($file, $cat['name']);
        fwrite($file, ">\n");
        fwrite($file, "ban_dir ");
        fwrite($file, $quer8['value']);
        fwrite($file, $cat['name']);
        fwrite($file, "\n");
        fwrite($file, "url ");
        if($cat['name'] != 'baner')
        {
            fwrite($file, $quer9['value']);
            fwrite($file, 'porno.html');
        }
        else
        {
            fwrite($file, $quer9['value']);
            fwrite($file, '1x1.gif');
        }
        fwrite($file, "\n");
        fwrite($file, "log off\n");
        $sql_cat = $cat['name'];
        $select_exc = "SELECT `user_ip` FROM `webroute`.`rej_exc` WHERE `cat_name`='$sql_cat'";
        $cat_q = mysql_query($select_exc);
        while ($cat_wh = mysql_fetch_assoc($cat_q))
        {
            fwrite($file, 'allow_ip ');
            fwrite($file, $ppp . $cat_wh['user_ip']);
            fwrite($file, "\n");
        }
        fwrite($file, "\n");

    }

    fclose($file);
    exec("sudo squid -k reconfigure");
}

?>
