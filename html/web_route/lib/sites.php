<?php
session_start();
include 'sql_to_sites.php';

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

if (isset ($_POST['add_allowed']))
{
    $url = $_POST['add_allowed'];
    $query = "INSERT INTO `site_allow` (`site`) VALUES ('$url')";
    mysql_query($query);
    $change = "allow";
    @header('Location: /web_route/admin/index.php?act=site_allow');
}
if (isset ($_GET['del_allowed']))
{
    $url = $_GET['del_allowed'];
    $query = "DELETE FROM `site_allow` WHERE `id`='$url'";
    mysql_query($query);
    $change = "allow";
    @header('Location: /web_route/admin/index.php?act=site_allow');
}

if (isset ($_POST['add_denyed']))
{
    $url = $_POST['add_denyed'];
    $query = "INSERT INTO `site_deny` (`site`) VALUES ('$url')";
    mysql_query($query);
    $change = "deny";
    @header('Location: /web_route/admin/index.php?act=site_deny');
}

if (isset ($_GET['del_denyed']))
{
    $url = $_GET['del_denyed'];
    $query = "DELETE FROM `site_deny` WHERE `id`='$url'";
    mysql_query($query);
    $change = "deny";
    @header('Location: /web_route/admin/index.php?act=site_deny');
}

sql_to_sites($change);

}
?>
