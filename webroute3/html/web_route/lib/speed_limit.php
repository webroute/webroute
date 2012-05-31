<?php
if ($_SESSION['role'] == 'admin')
{
    if(isset($_POST['submit_s']))
        {
            echo "<script>window.location.reload();</script>";
        }

    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);

    $all_users = "SELECT `login` FROM `users` ORDER BY `login`";
    $all_users = mysql_query($all_users);
    echo "<br><table border = \"1\" cellspacing =\"0\" cellpadding=\"5\"><tr><td>логин</td><td>тек. вх. скорость</td><td>тек. исх. скорость</td><td>устан. вх. скорость</td><td>устан. исх. скорость</td></tr>";
    function ch_speed($login)
    {
        $sel_aspeed = "SELECT * FROM `speed` order by `id`";
        $sp = mysql_query($sel_aspeed);
        $user = $login;
        echo "<select name=\"$user\" size=\"1\">\n";
        echo "<option selected value=\"-1\">без изменений</option>\n";
        while ($sel_aspeed = mysql_fetch_assoc($sp))
        {
            $awspeed = $sel_aspeed['w_speed'];
            echo "<option value=\"$awspeed\">$awspeed</option>";
        }
        echo "</select>";
    }

    function ch_speed_out($login){
        $sel_aspeed = "SELECT * FROM `speed` order by `id`";
        $sp2 = mysql_query($sel_aspeed);
        $user = $login.'out';
        echo "<select name=\"$user\" size=\"1\">\n";
        echo "<option selected value=\"-1\">без изменений</option>\n";
        while ($sel_aspeed = mysql_fetch_assoc($sp2))
        {
            $awspeed = $sel_aspeed['w_speed'];
            echo "<option value=\"$awspeed\">$awspeed</option>";
        }
        echo "</select>";

    }

echo "<form method=\"POST\">\n";
    while($users = mysql_fetch_assoc($all_users))
    {
        $user = $users['login'];
        $sel_speed = "SELECT `w_speed`,`ow_speed` FROM `conn_speed` WHERE `login`='$user'";
        $sel_speed = mysql_fetch_assoc(mysql_query($sel_speed));
        $speed = $sel_speed['w_speed'];
        $ospeed = $sel_speed['ow_speed'];
        echo "<tr><td>$user</td><td>$speed</td><td>$ospeed</td><td>";
        ch_speed($user);
        echo "</td><td>";
        ch_speed_out($user);
        echo "</td></tr>";

        if(isset($_POST['submit_s']))
        {
        $usr = $_POST["$user"];
        if($usr == -1) goto end;
        $sel_o_speed = "SELECT `speed` FROM `speed` WHERE `w_speed`='$usr'";
        $sel_tr_speed = "SELECT `speed` FROM `speed` WHERE `w_speed`='$usr'";
        $speed_r = mysql_fetch_assoc(mysql_query($sel_tr_speed));
        $spr = $speed_r['speed'];
        $query = "UPDATE `conn_speed` SET `w_speed`='$usr', `speed`='$spr' WHERE `login`='$user'";
        mysql_query($query);
        end:

        $usero = $user.'out';
        $usr = $_POST["$usero"];
        if($usr == -1) goto endo;
        $sel_tr_speed = "SELECT `speed` FROM `speed` WHERE `w_speed`='$usr'";
        $speed_r = mysql_fetch_assoc(mysql_query($sel_tr_speed));
        $spr = $speed_r['speed'];
        $query = "UPDATE `conn_speed` SET `ow_speed`='$usr', `ospeed`='$spr' WHERE `login`='$user'";
        mysql_query($query);
        endo:
        }

    }
echo "</table><br/><br/>";
echo "<input type=\"submit\" name=\"submit_s\" value=\"применить\">\n";
echo "</form>\n";
}
 else
{
@header('Location: /web_route');
}
?>
