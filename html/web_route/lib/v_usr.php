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
$mysql_sel_all = "SELECT `login`,`password`,`role` FROM `users` ORDER BY `login`";
$result = mysql_query($mysql_sel_all);
mysql_close($link);
echo '<br><table <table border="1" cellspacing="0" cellpadding="5">';
echo '<tr><td>логин</td><td>пароль</td><td>права</td></tr>';
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
			echo '<tr>'.'<td>' . $row['login'] . '</td><td>' . $row['password'] . '</td><td>' . $row['role'] . '</td></tr>';    
      }
echo '</table><br>';
}
?>