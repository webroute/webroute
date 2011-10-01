<?php
if ($_SESSION['role'] != 'admin')
	{
	@header('Location: /web_route');
	}
else 
{
$db_host = 'localhost';
$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());
$get_usr = "SELECT `id`, `login` FROM `users`";
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
        $id = $_POST['del_user'];
        $del_usr = "DELETE FROM `users` WHERE `users`.`login`='$id' LIMIT 1";
        $del_speed = "DELETE FROM `conn_speed` WHERE `login`='$id' LIMIT 1";
        mysql_query($del_usr);
        mysql_query($del_speed);
        sql_to_chap();
        mysql_close($link);
        echo "пользователь успешно удален.";
    }

}
?>