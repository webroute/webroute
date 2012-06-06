<?php
if ($_SESSION['role'] == 'admin')
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);
    if(isset($_POST['submit_s']))
        {
            $all_users1 = "SELECT `login` FROM `users` ORDER BY `login`";
            $all_users1 = mysql_query($all_users1);
            $user = $_POST['uname'];
            $in = $_POST['in_sp'];
            $out = $_POST['out_sp'];
            if($in == -1) goto end;
            $sel_in_speed = "SELECT `speed` FROM `speed` WHERE `w_speed`='$in'";
            $speed_in = mysql_fetch_assoc(mysql_query($sel_in_speed));
            $spr_in = $speed_in['speed'];
            $query = "UPDATE `conn_speed` SET `w_speed`='$in', `speed`='$spr_in' WHERE `login`='$user'";
            mysql_query($query);
            end:
            if($out == -1) goto endo;
            $sel_out_speed = "SELECT `speed` FROM `speed` WHERE `w_speed`='$out'";
            $speed_out = mysql_fetch_assoc(mysql_query($sel_out_speed));
            $spr_out = $speed_out['speed'];
            $query1 = "UPDATE `conn_speed` SET `ow_speed`='$out', `ospeed`='$spr_out' WHERE `login`='$user'";
            mysql_query($query1);
            endo:
        }

    $all_users = "SELECT `login` FROM `users` ORDER BY `login`";
    $all_users = mysql_query($all_users);
    echo "<br><table border = \"1\" cellspacing =\"0\" cellpadding=\"5\"><tr><td>логин</td><td bgcolor='#EBB9B8'>тек. вх. скорость</td><td bgcolor='#B5C3AC'>тек. исх. скорость</td><td bgcolor='#EBB9B8'>устан. вх. скорость</td><td bgcolor='#B5C3AC'>устан. исх. скорость</td> <td>действие</td></tr>";
    while($users = mysql_fetch_assoc($all_users))
    {
        echo "<form method=\"POST\">\n";
        $user = $users['login'];
        $sel_speed = "SELECT `w_speed`,`ow_speed` FROM `conn_speed` WHERE `login`='$user'";
        $sel_speed = mysql_fetch_assoc(mysql_query($sel_speed));
        $speed = $sel_speed['w_speed'];
        $ospeed = $sel_speed['ow_speed'];
        echo "<tr><td>$user</td><td bgcolor='#EBB9B8'>$speed</td><td bgcolor='#B5C3AC'>$ospeed</td><td bgcolor='#EBB9B8'>";
        ///========================in opt======================================
        $sel_aspeed_o = "SELECT * FROM `speed` order by `id`";
        $sp = mysql_query($sel_aspeed_o);
        echo "<select name=\"in_sp\" size=\"1\">\n";
        echo "<option selected value=\"-1\">без изменений</option>\n";
        while ($sel_aspeed = mysql_fetch_assoc($sp))
        {
            $awspeed = $sel_aspeed['w_speed'];
            echo "<option value=\"$awspeed\">$awspeed</option>";
        }
        echo "</select>";
        ///==============================================================
        echo "</td><td bgcolor='#B5C3AC'>";
        ///=========================out opt=====================================
        $sp2 = mysql_query($sel_aspeed_o);
        echo "<select name=\"out_sp\" size=\"1\">\n";
        echo "<option selected value=\"-1\">без изменений</option>\n";
        while ($sel_aspeed2 = mysql_fetch_assoc($sp2))
        {
            $awspeed2 = $sel_aspeed2['w_speed'];
            echo "<option value=\"$awspeed2\">$awspeed2</option>";
        }
        echo "</select>";
        ///==============================================================
        echo "</td><td><input type='hidden' value='$user' name='uname'><input type=\"submit\" name=\"submit_s\" value=\"применить\">\n</form>\n";
        echo "</td></tr>";
    }
echo "</table><br/><br/>";
}
 else
{
@header('Location: /web_route');
}
?>
