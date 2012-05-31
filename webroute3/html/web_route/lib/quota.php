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
////===Checking for removing quota ===
	if(isset ($_GET['del_q']))
    {
        $id = $_GET['del_q'];
        $del = "DELETE FROM `quota` WHERE `id` =" . $id;
        mysql_query($del);
        echo "<script language='javascript'>window.location = \"/web_route/admin/index.php?act=quota\"</script>";
    }
////===Checking for quota creation ===
    if(isset($_POST['sub_q']))
    {

        if(isset($_POST['q_usr']))
        {
            $qusr = trim($_POST['q_usr']);
        }
        else
        {
            echo "Вы не выбрали пользователя";
            exit;
        }

        if(isset($_POST['d_i_q']) and preg_match('/^[0-9]+$/', trim($_POST['d_i_q'])))
        {
             $diq = trim ($_POST['d_i_q']) * 1024 * 1024;
        }
        else
        {
            $diq = 0;
        }

        if(isset($_POST['d_o_q']) and preg_match('/^[0-9]+$/', trim($_POST['d_o_q'])))
        {
            $doq = trim($_POST['d_o_q']) * 1024 * 1024;
        }
        else
        {
            $doq = 0;
        }

        if(isset($_POST['m_i_q']) and preg_match('/^[0-9]+$/', trim($_POST['m_i_q'])))
        {
            $miq = trim($_POST['m_i_q']) * 1024 * 1024;
        }
        else
        {
            $miq = 0;
        }

        if(isset($_POST['m_o_q']) and preg_match('/^[0-9]+$/', trim($_POST['m_o_q'])))
        {
            $moq = trim($_POST['m_o_q']) * 1024 * 1024;
        }
        else
        {
            $moq = 0;
        }
        $sel_usr = "SELECT `login` FROM `users` WHERE `ip`=" . $qusr;
        $login = mysql_fetch_assoc(mysql_query($sel_usr));
        $login = $login['login'];
        $ppp_n = "SELECT `value` FROM `config` WHERE `key`='ppp_network'";
        $ppp_n = mysql_fetch_assoc(mysql_query($ppp_n));
        $ppp_ip = $ppp_n['value'] . $qusr;
        $ins_quota = "INSERT INTO `quota` (`login`,`ip`,`in_quota_d`,`out_quota_d`,`in_quota_m`,`out_quota_m`,`blocked`) VALUES ('$login','$ppp_ip','$diq','$doq','$miq','$moq','0')";
        mysql_query($ins_quota);

    }

    ////===New quota form creation ===
    $sel_usr = "SELECT `login`, `ip` FROM `users` ORDER BY `login`";
	$sel_usr = mysql_query($sel_usr);
    echo "<table border='0'><tr><td>";
    echo "<font size='2' class='dfss'>Внимание размер квот указывается в МЕГАБАЙТАХ.<br> Если Вы не хотите задавать какой-либо из параметров, то просто оставьте его пустым,<br> в этом случае ограничения по этому параметру не будет.</font><br><br>";
    echo "Создание новой квоты:<br/><br/>";
    echo "<form method=\"POST\">\n";
    echo "<table border='1' cellpadding='3' cellspacing='0'><tr>";
    echo "<td>пользователь</td>";
    echo "<td>днев. вход. квота</td>";
    echo "<td>днев. исх. квота</td>";
    echo "<td>мес. вход. квота</td>";
    echo "<td>мес. исх. квота</td></tr>";
    echo "<tr>";
    echo "<td>";
	echo "<select name=\"q_usr\" size=\"1\">\n";
	echo "<option disabled value='0'>выберите пользователя</option>\n";

	////===Generating the list of users ===
    while($users = mysql_fetch_assoc($sel_usr))
	{
		$user = $users['login'];
		$ip   = $users['ip'];
		echo "<option value=\"". $ip ."\">". $user ."</option>\n";
	}
    echo "</select>\n";
    echo "</td>";
    echo "<td><input type='text' name='d_i_q'></td>";
    echo "<td><input type='text' name='d_o_q'></td>";
    echo "<td><input type='text' name='m_i_q'></td>";
    echo "<td><input type='text' name='m_o_q'></td>";
    echo "</tr>";
    echo "</table>";
    echo "<input type='submit' name='sub_q' value='создать'>";
    echo "</form>\n";

    ////===List of quota ===
	$sel_blocked = 'SELECT `id`, `login`, `ip`, `in_quota_d`, `out_quota_d`, `in_quota_m`, `out_quota_m`,	`blocked`, `reason` FROM `quota` ORDER BY `login`';
	$q_blo = mysql_query($sel_blocked);
    echo "</br>Список существующих квот:</br><br>";
    echo "<table border='1' cellpadding='3' cellspacing='0'>";
    echo "<tr><td>пользователь</td>  <td>днев. вход. квота</td>  <td>днев. исх. квота</td>  <td>мес. вход. квота</td>  <td>мес. исх. квота</td>  <td>заблокирован?</td>  <td>причина блокир.</td> <td>действие</td> </tr>";
    while ($usr_blo = mysql_fetch_assoc($q_blo))
    {
        if ($usr_blo['blocked'] == 1)
        {
            $bl = "Да";
        }
        else
        {
            $bl = "Нет";
        }
        echo "<tr> <td>".$usr_blo['login']."</td>";
        echo "<td>".$usr_blo['in_quota_d']/1048576 ."</td>";
        echo "<td>".$usr_blo['out_quota_d']/1048576 ."</td>";
        echo "<td>". $usr_blo['in_quota_m']/1048576 ."</td>";
        echo "<td>".$usr_blo['out_quota_m']/1048576 ."</td>";
        echo "<td>". $bl ."</td>";
        echo "<td>". $usr_blo['reason'] ."</td>";
        echo "<td><a href='/web_route/admin/index.php?act=quota&del_q=".$usr_blo['id']."'>удалить</a></td> </tr>";
    }
    echo "</table>";
    echo "</td></tr></table>";
}
?>