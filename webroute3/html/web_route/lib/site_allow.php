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
    $sql = "SELECT * FROM `sites` WHERE `act`='allow'";
    $sites = mysql_query($sql);
    echo "<table><tr><td><div align=\"left\">";
    echo 'Для добавления сайта к списку разрешенных, следует писать его название БЕЗ "www."<br/>';
    echo 'Разрешив домен нижнего уровня Вы разрешите и домены верхних уровней.<br/>';
    echo 'Например: разрешив yandex.ru Вы разрешите и musik.yandex.ru и fotki.yandex.ru .<br/>';
    echo "<br/>";
    echo "<form method=\"POST\" action=/web_route/lib/sites.php>";
    echo "Введите адресс сайта&nbsp;<input type=\"text\" name=\"add_allowed\">";
    echo "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"добавить\">";
    echo "</br></br>Список разрешенных сайтов</br><table border = \"1\" cellspacing =\"0\">";
    while($site = mysql_fetch_assoc($sites))
    {
        echo "<tr><td>";
        echo $site['site'];
        echo "</td><td>";
        echo "<a href = \"/web_route/lib/sites.php?del_allowed= ";
        echo $site['id'];
        echo "\">удалить</a></td></tr>";


    }
    echo "</table></div></td></tr></table>";
}
?>
