<?php
session_start();
if ($_SESSION['role'] != 'admin')
	{
            @header('Location: /web_route');
	}
else
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);
    
    if(isset ($_GET['dwc']))
    {
    $action = 0;
    $cate = $_GET['dwc'];
    $upd_cat = "UPDATE  `webroute`.`rej_categories` SET  `enabled` =  '$action' WHERE  `rej_categories`.`id` ='$cate' LIMIT 1 ;";
    mysql_query($upd_cat);
    @header('Location: /web_route/admin/index.php?act=web_acc');
    //header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    if(isset ($_GET['ewc']))
    {
    $action = 1;
    $cate = $_GET['ewc'];
    $upd_cat = "UPDATE  `webroute`.`rej_categories` SET  `enabled` =  '$action' WHERE  `rej_categories`.`id` ='$cate' LIMIT 1 ;";
    mysql_query($upd_cat);
    @header('Location: /web_route/admin/index.php?act=web_acc');
    //header("Location: {$_SERVER['HTTP_REFERER']}");
    }

include 'sql_to_redirector.php';
sql_to_redirector();
mysql_close($link);
}
?>
