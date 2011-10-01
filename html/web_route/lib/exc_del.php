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

    $cat = $_GET['cat'];
    $usr = $_GET['usr'];

    $query = "DELETE FROM `rej_exc` WHERE `rej_exc`.`cat_name` = '$cat' and `rej_exc`.`user_name` = '$usr' LIMIT 1";
    mysql_query($query);
    @header('Location: /web_route/admin/index.php?act=web_exept');
    include 'sql_to_redirector.php';
    sql_to_redirector();
    mysql_close($link);
}

?>
