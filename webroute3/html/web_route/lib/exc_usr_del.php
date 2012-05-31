<?php
session_start();
if ($_SESSION['role'] != 'admin'){
            @header('Location: /web_route');
	}
else{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);

    $site = $_GET['site'];
    $usr = $_GET['usr'];
    $act = $_GET['act'];
    $query = "DELETE FROM `rej_usr_exc` WHERE `site` = '$site' and `user` = '$usr' and `action` = '$act' LIMIT 1";
    mysql_query($query) or die(mysql_error());
    include 'sql_to_redirector.php';
    sql_to_redirector();
    mysql_close($link);
    if($act == 'allow'){
       @header('Location: /web_route/admin/index.php?act=usr_exept');
    }else{
       @header('Location: /web_route/admin/index.php?act=usr_den');
    }

}
?>
