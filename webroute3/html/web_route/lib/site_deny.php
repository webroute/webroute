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
    mysql_set_charset('utf8',$link);
    $sql = "SELECT * FROM `sites` WHERE `act`='deny'";
    $sites = mysql_query($sql);
    echo "<table><tr><td><div align=\"left\"><br>";
    echo 'Для добавления сайта к списку запрещенных, следует писать его название БЕЗ "www."<br/>';
    echo 'Запретив домен нижнего уровня Вы запретите и домены верхних уровней.<br/>';
    echo 'Например: запретив google.com Вы запретите и news.google.com и mail.google.com .<br/>';
    echo "<br/>";
    echo "<form method=\"POST\" action=/web_route/lib/sites.php>";
    echo "Введите адресс сайта&nbsp;<input type=\"text\" name=\"add_denyed\">";
    echo "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"добавить\">";
    echo "</br></br>Список запрещенных сайтов</br><table border = \"1\" cellspacing =\"0\">";
    while($site = mysql_fetch_assoc($sites))
    {
        echo "<tr><td>";
        echo $site['site'];
        echo "</td><td>";
        echo "<a href = \"/web_route/lib/sites.php?del_denyed= ";
        echo $site['id'];
        echo "\">удалить</a></td></tr>";


    }
    echo "</table></div></td></tr></table>";
}
?>
