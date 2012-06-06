<?php
@session_start();
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

    function sql_to_l7filter(){
        $queryy = "SELECT `code`, `name` FROM `l7protocols` WHERE `enabled`=1";
        $ress = mysql_query($queryy);
        $file = "/etc/l7-filter.conf";
        $file = fopen($file, 'w');
        while($reess = mysql_fetch_assoc($ress)){
            $code = $reess['code'];
            $name = $reess['name'];
            $str = $name .'    '.$code. "\n";
            fwrite($file, $str);
        }
        fclose($file);
        exec('sudo /usr/bin/killall l7-filter');
        exec('sudo /usr/bin/l7-filter -f /etc/l7-filter.conf -z');
    }

    if(isset($_GET['di'])){
        $di = $_GET['di'];
        $q = "UPDATE  `l7protocols` SET  `enabled` =  0 WHERE  `id` ='$di' LIMIT 1";
        mysql_query($q) or die(mysql_error());
        sql_to_l7filter();
    }

    if(isset($_GET['en'])){
        $en = $_GET['en'];
        $q = "UPDATE  `l7protocols` SET  `enabled` =  1 WHERE  `id` ='$en' LIMIT 1";
        mysql_query($q) or die(mysql_error());
        sql_to_l7filter();
    }

    $query = "SELECT * FROM `l7protocols`";
    $res =  mysql_query($query);
    echo "<table border='1' cellpadding='5' cellspacing='0'><tr>";
    echo "<td>название</td><td>скорость</td><td>описание</td><td>состояние</td></tr>";
    while($proto = mysql_fetch_assoc($res)){
        $protocol = $proto['name'];
        $id       = $proto['id'];
        $desc     = $proto['description'];
        $speed    = $proto['speed'];
        $state    = $proto['enabled'];
        if($state == 1){
            $color = "#EBB9B8";
            $link = "<a href=\"/web_route/admin/index.php?act=l7proto&di=$id\">выключить</a>";
        }else{
            $color = "#B5C3AC";
            $link = "<a href=\"/web_route/admin/index.php?act=l7proto&en=$id\">включить</a>";
        }
        echo "<tr><td bgcolor='$color'>$protocol</td><td>$speed</td><td>$desc</td><td>$link</td></tr>";
    }
    echo "</table>";
    echo "</td></tr></table>";
}
?>
