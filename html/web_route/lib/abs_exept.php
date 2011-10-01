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

    $select_abs = "SELECT `login` FROM `webroute`.`rej_abs_exc`";
    $abs = mysql_query($select_abs);

    if(isset($_POST['submit_abs']))
    {
        $usr_add = $_POST['login'];
        $ip_q = "SELECT `ip` FROM `users` WHERE `login`='$usr_add'";
        $ip_n = mysql_query($ip_q);
        $ip = mysql_fetch_assoc($ip_n);
        $usr_ip = $ip['ip'];
        $quer = "INSERT INTO  `webroute`.`rej_abs_exc` (`usr_ip` ,`login`)VALUES ('$usr_ip', '$usr_add')";
        mysql_query($quer);
        include "sql_to_redirector.php";
        sql_to_redirector();
        @header('Location: /web_route/admin/index.php?act=abs_exept');
    }
    echo "<table><tr><td>";
    echo "<form method=\"POST\">\n";
    echo "&nbsp;Добавить абсолютное исключение\n<br/>";
    echo "<select name=\"login\" size=\"1\">\n";
    echo "<option disabled>выберите пользователя</option>\n";
    $sel_usr = "SELECT `login` FROM `users`";
    $usr_nm = mysql_query($sel_usr);
    while($use = mysql_fetch_assoc($usr_nm))
    {
        echo "<option>";
        echo $use['login'];
        echo "</option>\n";
    }
    echo "</select>&nbsp;&nbsp;&nbsp;";
    echo "<input type=\"submit\" name=\"submit_abs\" value=\"добавить\">\n";
    echo '<br/><br/><br/>Удалить абсолютное исключение';
    echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"3\">";
    echo "<tr><td>пользователь</td><td>действие</td></tr>";
    while($abs_ex = mysql_fetch_assoc($abs))
    {
        echo "<tr><td>";
        echo $abs_ex['login'];
        echo "</td><td><a href=\"/web_route/lib/abs_del.php?usr=";
        echo $abs_ex['login'];
        echo "\">удалить</a>";
        echo "</td></tr>";
    }
    echo "</table>";
    echo "</td></tr></table>\n";
}
mysql_close($link);

?>
