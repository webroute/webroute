<?php
@session_start();
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
    include('sql_to_skipusr.php');
    $sel_usr = "SELECT `login` FROM `users` ORDER BY `login`";
    $usr_nm = mysql_query($sel_usr);
    print <<< eee
    Исключить пользователя из отчетов статистики.</br></br>
    <form method="POST">
        <select name="userid" size="1">
        <option disabled>выберите пользователя</option>\n
eee;
        while($use = mysql_fetch_assoc($usr_nm))
        {
            echo "<option>".$use['login']."</option>\n";
        }
    print <<< rrrr
        </select>
        <input type="submit" name="submit_rep_exc" value="добавить">
    </form>
    </br></br>
rrrr;

    if(isset($_POST['submit_rep_exc'])){
        $userid = $_POST['userid'];
        add_skip_user($userid);
        echo '<script type="text/javascript">location.reload();</script>';
    }

    if(isset($_GET['ac']) and $_GET['ac'] == 'rem'){
    $usrid2 = $_GET['uid'];
    del_skip_user($usrid2);
    echo '<script type="text/javascript">location.replace("/web_route/admin/index.php?act=rep_settings");</script>';
    }

    echo "Список пользователей по которым не ведется стятистика.</br></br>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    $select_except2 = "SELECT `id`,`userid` FROM `report_except`";
    $res2 = mysql_query($select_except2) or die(mysql_error());
    while($res3 = mysql_fetch_assoc($res2)){
        echo "<tr><td>".$res3['userid']."</td><td><a href=\"/web_route/lib/rep_settings.php?ac=rem&uid=".$res3['id']."\">удалить</a></td></tr>";
    }
    echo "</table>";
    mysql_close($link);
}
?>
