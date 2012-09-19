<?php
//###--- version 3.2.0 ---####//
if ($_SESSION['role'] != 'admin')
	{
	@header('Location: /web_route');
	}
else 
{
$db_host = 'localhost';
$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());
$mysql_sel_all = "SELECT `login`,`password`,`role` FROM `users` ORDER BY `login`";
$result = mysql_query($mysql_sel_all);
///////////////////////////////////////new user
include_once 'sql_to_chap.php';
print <<<html22
				<!---div align="left"--->
				<script type="text/javascript">
				jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
                        jAlert('Confirmed: ' + r, 'Confirmation Results');
                });
				</script>

				<table><tr><td>
                <form method="POST">
                <br/>
                <table><tr><td  colspan=2><font color='blue'>Создание нового пользователя.</font></td></tr><tr><td>
				логин </td><td><input type="text" name="login"/></td></tr><tr><td>
				пароль</td><td><input type="text" name="pass"/></td></tr><tr><td>
				права</td><td>
				<select name="role" size="1">
				<option selected value="user">Пользователь</option>
				<option value="statistic">Просмотр статистики</option>
				<option value="admin">Администратор</option>
				</select></td></tr><tr><td>
				<input type="submit" name="submitadd" value="создать" onclick='jConfirm()' /></td></tr></table>
				</form>
                </td></tr></table>
				<!---/div--->
html22;

    if(isset($_POST['submitadd']))
	{
		$login = $_POST['login'];
		$password = $_POST['pass'];
		$role = $_POST['role'];
                $user_ok = preg_match('/^[a-zA-Z0-9]+$/', $login);
                $pass_ok = preg_match('/^[a-zA-Z0-9]+$/', $password);

                function create_ip()
                {
                  $query = "SELECT `ip` FROM `users`";
                  $result = mysql_query($query);
                  $av_ip = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,
                  36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,
                  72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,
                  106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,
                  133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,
                  160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,
                  187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,
                  214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,
                  241,242,243,244,245,246,247,248,249,250,251,252,253,254);
                  $used_ip[] = 1;
                  while($mass = mysql_fetch_assoc($result))
                    {
                      foreach($mass as $key => $value)
                      {
                          $used_ip[] = $value;
                      }

                    }
                $t_ip = array_diff($av_ip, $used_ip);
                foreach($t_ip as $key => $value)
                      {
                          $ip = $value;
                          break;
                      }
                return $ip;
                }

                $search_user = "SELECT `login` FROM `users` WHERE `login`='$login'";
                $sql_usr_srch = mysql_fetch_assoc( mysql_query($search_user, $link));

                if ($login == $sql_usr_srch['login'])
                {
                    echo '<font color="red">Такой пользователь уже существует!</font>';
                    echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 2500);</script>';
                   }
                elseif ($user_ok != 1 or $pass_ok != 1)
                {
                    echo "<font color='red'>Логин и пароль должны состоять из латинских букв и/или цифр</font>";
                    echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 2500);</script>';
                }
                else
                {
                    $i = create_ip();
                    if($i < 2) {
                        echo '<font color="red">Лимит количества пользователей превышен!</font>';
                        echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 2500);</script>';
                        exit;
                    }
                    $sql_reg = "INSERT INTO `users` (`login`,`password`,`role`, `ip`) VALUES ('$login','$password','$role','$i')";
                    mysql_query($sql_reg);
                    $sel_id = "SELECT `id` FROM `users` WHERE `login`='$login'";
                    $rej_ban_pref = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_ban_pref'";
                    $id = mysql_fetch_assoc(mysql_query($sel_id));
                    $ban_pref = mysql_fetch_assoc(mysql_query($rej_ban_pref));
                    $ban_pref = $ban_pref['value'];
                    $usr_path = $ban_pref . 'usr/' .$id['id'] ;
                    mkdir($usr_path, 0777);
                    $den_path = $ban_pref . 'den/' .$id['id'] ;
                    mkdir($den_path, 0777);
                    $ppp_n = "SELECT `value` FROM `config` WHERE `key`='ppp_network'";
                    $ppp_n = mysql_fetch_assoc(mysql_query($ppp_n));
                    $ppp_ip = $ppp_n['value'] . $i;
                    $set_sp = "INSERT INTO `conn_speed` (`login`, `ip`, `speed`, `w_speed`, `ospeed`, `ow_speed`) VALUES ('$login', '$ppp_ip', '0', 'unlim', '0', 'unlim')";
                    mysql_query($set_sp);
                    include_once "sql_to_redirector.php";
                    include_once 'sql_to_skipusr.php';
                    sql_to_redirector();
                    sql_to_skipuser();
                    echo '</br><font color="red">Пользователь успешно добавлен.</font></br>';
                    echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 2500);</script>';
                    sql_to_chap();
                }
    }
//////////////////////////////////////new user end
////////////////////////////////////remove user
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

if (isset ($_GET['do']) and $_GET['do'] == 'del')
    {
        include_once 'sql_to_skipusr.php';
        include_once "sql_to_redirector.php";
        $id = $_GET['usr'];
        $del_usr = "DELETE FROM `users` WHERE `users`.`login`='$id' LIMIT 1";
        $del_speed = "DELETE FROM `conn_speed` WHERE `login`='$id'";
        $del_quota = "DELETE FROM `quota` WHERE `login`='$id'";
        $del_rep_exc = "DELETE FROM `report_except` WHERE `userid`='$id'";
        $sel_id = "SELECT `id` FROM `users` WHERE `login`='$id'";
        $rid = mysql_fetch_assoc(mysql_query($sel_id));
        $rej_ban_pref = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_ban_pref'";
        $ban_pref = mysql_fetch_assoc(mysql_query($rej_ban_pref));
        $ban_pref = $ban_pref['value'];
        $usr_path = $ban_pref . 'usr/' .$rid['id'];
        $den_path = $ban_pref . 'den/' .$rid['id'];
        rrmdir($usr_path);
        rrmdir($den_path);
        $idu = $rid['id'];
        $del_usrexc = "DELETE FROM `rej_usr_exc` WHERE `user` = '$idu'";
        mysql_query($del_usr);
        mysql_query($del_speed);
        mysql_query($del_quota);
        mysql_query($del_rep_exc);
        mysql_query($del_usrexc);
        sql_to_chap();
        sql_to_skipuser();
        sql_to_redirector();
        exec("sudo squid -k reconfigure");
        echo '</br><font color="red">Пользователь успешно удален.</font></br>';
        echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 2500);</script>';
    }
///////////////////////////////remove users end
///////////////////////////////list of users
echo '<br><table <table border="1" cellspacing="0" cellpadding="5">';
echo '<tr><td colspan="3"><font color="blue">Список существующих пользователей.</font></td></tr>';
echo '<tr><td>логин</td><td>права</td><td>действие</td></tr>';
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
			echo '<tr>'.'<td>' . $row['login'] . '</td><td>' . $row['role'] . "</td><td><a href=\"{$_SERVER['PHP_SELF']}?act=v_usr&do=del&usr=".$row['login'].'"onclick="return confirm(\'Удалить пользователя '.$row['login'].' ?\')">удалить</a>';
            echo "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?act=ch_pass&usr=".$row['login']."\">сменить пароль</a></td></tr>";
      }
echo '</table><br>';
mysql_close($link);
}
///////////////////////////////list of users end
?>
        