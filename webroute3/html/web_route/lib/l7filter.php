<?php
if ($_SESSION['role'] != 'admin')
	{
            @header('Location: /web_route');
	}
else
{
    echo "<table border='0'><tr><td>";
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);
    
    echo "<table border='0'>";
    echo "<form name='l7user' method='post'>";
    echo "<tr><td>";
    $q = "SELECT `login` FROM `users` ORDER BY `login`";
    $res = mysql_query($q);
    echo "<select name=\"usr_name\" size=\"1\">\n";
    echo "<option disabled>выберите пользователя</option>\n";
    while($users = mysql_fetch_assoc($res)){
        $user = $users['login'];
        echo"<option>$user</option>";
    }
    echo "</select>";
    echo "</td><td>";
    echo "<select name=\"proto\" size=\"1\">\n";
    echo "<option disabled>выберите протокол</option>\n";
    $qpr = "SELECT `name` FROM `l7protocols` WHERE `enabled`=1";
    $respr = mysql_query($qpr);
    while($protocols = mysql_fetch_assoc($respr)){
        $proto = $protocols['name'];
        echo "<option>$proto</option>";
    }
    echo "</select>";
    echo "</td><td><input type='submit' name='add' value='запретить'>";
    echo"</td><td></td></tr>";
    echo "</form>";
    echo "</table>";

    if(isset($_POST['add'])){
        $login = $_POST['usr_name'];
        $prot = $_POST['proto'];
        $sel_ip = "SELECT `ip` FROM `users` WHERE `login`='$login'";
        $result = mysql_fetch_assoc(mysql_query($sel_ip));
        $ip = $result['ip'];
        $sel_pc = "SELECT `code` FROM `l7protocols` WHERE `name`='$prot'";
        $ress = mysql_fetch_assoc(mysql_query($sel_pc));
        $proto_code = $ress['code'];
        $ins_query = "INSERT INTO `l7filter` (`ip`, `proto_code`, `user`) VALUES ('$ip', '$proto_code', '$login')";
        mysql_query($ins_query);
    }

    if(isset($_GET['del'])){
        $usr = $_GET['usr'];
        $pr = $_GET['proto'];
        $dell = "DELETE FROM `l7filter` WHERE `user`= '$usr' AND `proto_code`= '$pr'";
        mysql_query($dell);
    }

    echo "<br><br><table border='1' cellpadding='5' cellspacing='0'><tr><td>пользователь</td><td>протокол</td></tr>";
    $sel_login = mysql_query($q);
    while($logins = mysql_fetch_assoc($sel_login)){
        $loginq = $logins['login'];
        echo "<tr><td>$loginq</td>";
        $qproname = "SELECT `proto_code` FROM `l7filter` WHERE `user`='$loginq'";
        $resa = mysql_query($qproname);
        echo '<td>';
        while ($resq = mysql_fetch_assoc($resa)){
            $proc = $resq['proto_code'];
            $sel_name = "SELECT `name` FROM `l7protocols` WHERE `code`='$proc'";
            $name = mysql_fetch_assoc(mysql_query($sel_name));
            $proto_name = $name['name'];
            echo "<a href=\"/web_route/admin/index.php?act=l7filter&del&usr=$loginq&proto=$proc\">".$proto_name."</a><br>";
        }
        echo "</td></tr>";
    }
    echo "</table>";

    echo "</td></tr></table>";
}
?>
