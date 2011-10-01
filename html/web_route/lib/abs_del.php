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
    $usr = $_GET['usr'];
    $query = "DELETE FROM `rej_abs_exc` WHERE `rej_abs_exc`.`login` = '$usr' LIMIT 1";
    mysql_query($query);
    include 'sql_to_redirector.php';
    sql_to_redirector();
    mysql_close($link);
    @header('Location: /web_route/admin/index.php?act=abs_exept');
}
?>
