<?php
if ($_SESSION['role'] != 'admin')
	{
	@header('Location: /web_route');
	}
else 
{
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }
$db_host = 'localhost';
$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());
$get_usr = "SELECT `id`, `login` FROM `users` ORDER BY `login`";
$g_usr = mysql_query($get_usr);
echo "<table><tr><td><div align=\"left\">\n";
echo "<form method=\"POST\">\n";
echo "<select name=\"del_user\" size=\"1\">\n";
echo "<option disabled>выберите пользователя</option>\n";
while($usr = mysql_fetch_assoc($g_usr))
  {
    echo "<option value=\"" . $usr['login'] . "\">" . $usr['login'] . "</option>\n";
  }
echo "</select>\n";
echo "<br/><br/>&nbsp\n";
echo "<input type=\"submit\" name=\"submit\" value=\"удалить пользователя\">\n";
echo "</form>\n";
echo "</div>\n</td></tr></table>";

if (isset ($_POST['submit']))
    {
        include 'sql_to_chap.php';
        include 'sql_to_skipusr.php';
        include "sql_to_redirector.php";
        $id = $_POST['del_user'];
        $del_usr = "DELETE FROM `users` WHERE `users`.`login`='$id' LIMIT 1";
        $del_speed = "DELETE FROM `conn_speed` WHERE `login`='$id'";
        $del_quota = "DELETE FROM `quota` WHERE `login`='$id'";
        $del_rep_exc = "DELETE FROM `report_except` WHERE `userid`='$id'";
        $sel_id = "SELECT `id` FROM `users` WHERE `login`='$id'";
        $rid = mysql_fetch_assoc(mysql_query($sel_id));
        $rej_ban_pref = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_ban_pref'";
        $ban_pref = mysql_fetch_assoc(mysql_query($rej_ban_pref));
        $ban_pref = $ban_pref['value'];
        $usr_path = $ban_pref . 'usr/' .$rid['id'];
        $den_path = $ban_pref . 'den/' .$rid['id'];
        rrmdir($usr_path);
        rrmdir($den_path);
        $idu = $rid['id'];
        $del_usrexc = "DELETE FROM `rej_usr_exc` WHERE `user` = '$idu'";
        mysql_query($del_usr);
        mysql_query($del_speed);
        mysql_query($del_quota);
        mysql_query($del_rep_exc);
        mysql_query($del_usrexc);
        sql_to_chap();
        sql_to_skipuser();
        sql_to_redirector();
        exec("sudo squid -k reconfigure");
        mysql_close($link);
        echo "<script language='javascript'>window.location = \"/web_route/admin/index.php?act=del_usr\"</script>";
        //echo "пользователь успешно удален.";
    }
}
?>
