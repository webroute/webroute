<?php
session_start();
$db_host = 'localhost';
$login = $_POST['login'];
$password = $_POST['pass'];

$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());

if (isset($_POST['submit']))
{

		$mysql_sel = "SELECT `login`,`password`, `role` FROM `users` WHERE login='$login'";
		$result = mysql_query($mysql_sel);
		$mass = mysql_fetch_assoc($result);

		if ($login == $mass['login'] and $password == $mass['password'] and $mass['role'] == 'admin' )
		{
			$_SESSION['login'] = $login;
			$_SESSION['register'] = true;
			$_SESSION['role'] = 'admin';
                        //$_SESSION['user_ch_pass'] = 1;
			@header('Location: /web_route/admin');
		}
		elseif($login == $mass['login'] and $password == $mass['password'] and $mass['role'] == 'statistic')
		{		
			$_SESSION['login'] = $login;
			$_SESSION['register'] = true;
			$_SESSION['role'] = 'statistic';			
			@header('Location: /web_route/statistics');
		}
		elseif($login == $mass['login'] and $password == $mass['password'] and $mass['role'] == 'user')
		{					
			$_SESSION['login'] = $login;
			$_SESSION['register'] = true;
			$_SESSION['role'] = 'user';		
			@header('Location: /web_route/user');			
		}	
		else 
		{
			echo'введенные вами логин и пароль неверны';
		}

                $mysql_sel2 = "SELECT `value` FROM `config` WHERE `key`='user_change_pass'";
		$result2 = mysql_query($mysql_sel2);
		$mass2 = mysql_fetch_assoc($result2);
		if ($mass2['value'] == 1)
		{
			$_SESSION['user_ch_pass'] = 1;
		}
		else
		{
			$_SESSION['user_ch_pass'] = 0;
		}
}
mysql_close($link);
?>