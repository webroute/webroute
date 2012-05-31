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

    if(isset($_POST['submit_usr']))
    {
        $cat_add = $_POST['domen'];
        $usr_add = $_POST['usr_name'];
        $id_q = "SELECT `id` FROM `users` WHERE `login`='$usr_add'";
        $id_n = mysql_query($id_q);
        $id = mysql_fetch_assoc($id_n);
        $usr_id = $id['id'];
        //echo $usr_id;
        $quer = "INSERT INTO  `webroute`.`rej_usr_exc` (`user` ,`site`, `action`)VALUES ('$usr_id', '$cat_add', 'allow')";
        mysql_query($quer);
        include "sql_to_redirector.php";
        sql_to_redirector();
        @header('Location: /web_route/admin/index.php?act=usr_exept');
    }

    echo '<table><tr><td>';
    echo "<br><form method=\"POST\">\n";
    echo "&nbsp;Добавить пользовательское исключение\n<br/>";
    echo "<select name=\"usr_name\" size=\"1\">\n";
    echo "<option disabled>выберите пользователя</option>\n";
    $sel_usr = "SELECT `login` FROM `users` ORDER BY `login`";
    $usr_nm = mysql_query($sel_usr);
    while($use = mysql_fetch_assoc($usr_nm))
    {
        echo "<option>";
        echo $use['login'];
        echo "</option>\n";
    }
    echo "</select>&nbsp;&nbsp;&nbsp;";
    echo "<input name='domen' type='text' size='30'>\n";
    echo "<input type=\"submit\" name=\"submit_usr\" value=\"добавить\"></form>\n";

    $select_usr = "SELECT `id`, `login` FROM `users` ORDER BY `login`";
    $usr1 = mysql_query($select_usr);
    echo "<br/>Удалить пользовательское исключение\n<br/><table border=\"1\" cellspacing=\"0\" cellpadding=\"3\">";
    echo "<tr><td>пользователь</td><td>сайт</td></tr>";
    while($usr = mysql_fetch_assoc($usr1))
    {
        $usr_login = $usr['login'];
        $usr_id = $usr['id'];
        $select_cat_ex = "SELECT * FROM `webroute`.`rej_usr_exc` WHERE `user` = '$usr_id' and `action`='allow' ORDER BY `site`";
        $categ_ex = mysql_query($select_cat_ex);
        echo "<tr><td>";
        echo $usr_login;
        echo "</td><td>";
        while($cat_ex = mysql_fetch_assoc($categ_ex))
        {
            echo "<a href=\"/web_route/lib/exc_usr_del.php?usr=";
            echo $cat_ex['user'];
            echo "&site=";
            echo $cat_ex['site'];
            echo "&act=allow";
            echo "\">";
            echo $cat_ex['site'];
            echo "</a>";
            echo "<br/>";
        }
        echo "</td></tr>";

    }
    echo "</table><br><br>";

    echo '</td></tr></table>';
}
?>
