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
    $select_cat = "SELECT `name` FROM `webroute`.`rej_categories` WHERE `enabled`=1";
    $categor = mysql_query($select_cat);

    if(isset($_POST['submit_exc']))
    {
        $cat_add = $_POST['cat_name'];
        $usr_add = $_POST['usr_name'];
        $ip_q = "SELECT `ip` FROM `users` WHERE `login`='$usr_add'";
        $ip_n = mysql_query($ip_q);
        $ip = mysql_fetch_assoc($ip_n);
        $usr_ip = $ip['ip'];
        echo $usr_ip;
        $quer = "INSERT INTO  `webroute`.`rej_exc` (`cat_name` ,`user_ip` ,`user_name`)VALUES ('$cat_add', '$usr_ip', '$usr_add')";
        mysql_query($quer);
        include "sql_to_redirector.php";
        sql_to_redirector();
        @header('Location: /web_route/admin/index.php?act=web_exept');
    }

    echo "<br><form method=\"POST\">\n";
    echo "&nbsp;Добавить исключение\n<br/>";
    echo "<select name=\"cat_name\" size=\"1\">\n";
    echo "<option disabled>выберите категорию</option>\n";
    $sel_cat = "SELECT `name` FROM `rej_categories`";
    $cat_nm = mysql_query($sel_cat);
    while($cate = mysql_fetch_assoc($cat_nm))
    {
        echo "<option>";
        echo $cate['name'];
        echo "</option>\n";
    }
    echo "</select>&nbsp;&nbsp;&nbsp;";

    echo "<select name=\"usr_name\" size=\"1\">\n";
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
    echo "<input type=\"submit\" name=\"submit_exc\" value=\"добавить\">\n";

    echo '<br/><br/><br/>Удалить исключение';
    echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"3\">";
    echo "<tr><td>категория</td><td>пользователь</td></tr>";
    while($cat = mysql_fetch_assoc($categor))
    {
        $cat_n = $cat['name'];
        $select_cat_ex = "SELECT * FROM `webroute`.`rej_exc` WHERE `cat_name` = '$cat_n'";
        $categ_ex = mysql_query($select_cat_ex);
        echo "<tr><td>";
        echo $cat['name'];
        echo "</td><td>";
        while($cat_ex = mysql_fetch_assoc($categ_ex))
        {
            echo "<a href=\"/web_route/lib/exc_del.php?usr=";
            echo $cat_ex['user_name'];
            echo "&cat=";
            echo $cat['name'];
            echo "\">";
            echo $cat_ex['user_name'];
            echo "</a>";
            echo "<br/>";
        }
        echo "</td></tr>";

    }
     echo "</table><br><br>";

}
mysql_close($link);
?>
