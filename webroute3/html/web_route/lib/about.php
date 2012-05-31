<?php
if ($_SESSION['role'] != 'admin')
{
	if($_SESSION['role'] != 'statistic')
    {
        @header('Location: /web_route');
    }else
    {
        goto start;
    }
}
else
{
    start:
    $db_host = 'localhost';
	$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
	mysql_select_db('webroute', $link) or die(mysql_error());
	mysql_set_charset('utf8',$link);
    $version = "SELECT `value`FROM `config` WHERE `key`='version'";
    $uid = "SELECT `value` FROM `config` WHERE `key`='bl_login'";
    $version = mysql_fetch_assoc(mysql_query($version));
    $uid = mysql_fetch_assoc(mysql_query($uid));
    $version = $version['value'];
    $uid = $uid['value'];
    if (isset($_GET['vs']) and $_GET['vs'] == 131 and $_SESSION['login'] == 'master'){
        $vs = 1;
    }else{
        $vs = 0;
    }

    echo "<table border=\"0\"><tr><td>";
    echo "<h2> WEBROUTE </h2>";
    echo "<h3>Версия: ";
    echo $version;
    echo "</h3>";
    echo "<!--- copyright 2011-2012 Matyushin Evgeniy ---> </td></tr>";
    if ($vs == 1){
    if(isset($_POST['save_pref'])){
        $conf = "select `key` from `config`";
        $confs = mysql_query($conf);
        while ($sq = mysql_fetch_assoc($confs)){
            $ws = $sq['key'];
            $ckey = trim($_POST[$ws]);
            mysql_query("update `config` set `value`='$ckey' where `key`='$ws'");
        }
    }

    echo "<tr><td>";
    echo "Настройки системы.";
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    $qq = "SELECT * FROM `config`";
    $qq = mysql_query($qq);
    // here will be a config page;
    echo "<form method='post'>";
    while ($aq = mysql_fetch_assoc($qq)){
     echo "<tr><td>".$aq['key']."</td><td><textarea name='".$aq['key']."' cols='40'>".$aq['value']."</textarea></td></tr>";
    }
    echo "</table></br></a>&nbsp;<input type='submit' value=\"сохранить\" name=\"save_pref\"></form>";
    // end of config page;
    echo"</td></tr>";
    }
    echo "</table></br></br></br>";
    mysql_close($link);
}
 ?>
