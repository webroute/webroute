<?php
session_start();
if ($_SESSION['role'] != 'statistic')
	{
	@header('Location: /web_route');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>webroute</title>
  <meta name="webroute">
</head>

<body bottommargin="0" leftmargin="0" topmargin="0" rightmargin="0">
<table border="0" cellspacing="0" cellpadding="0" height="100%" width="100%">
<tr>
	<td width="100%" height="80">
	<table width="100%" height="80"cellspacing="0" cellpadding="0" border="0">
	<tr>
	<td width="350" height="80"><img src="../img/logo.jpg" alt="logo webroute"></td>
	<td><img src="../img/logo2.png" alt="logo2 webroute" width="100%" height="80"></td>
	</tr>
	</table>
	</td>
</tr>

<tr>
	<td>
		<table border="0" cellspacing="0" cellpadding="0" height="100%" width="100%">
		<tr>
			<td width="180" valign="top">
<?php
		print <<<HTML
                                        <table border="0" cellspacing="1">
					<tr><td bgcolor="61e31a"><a href="{$_SERVER['PHP_SELF']}?act=ch_pass">Изменить пароль</a></td></tr>
					<tr><td bgcolor="61e31a"><a href="{$_SERVER['PHP_SELF']}?act=rep_traf">Отчет по трафику</a></td></tr>
					<tr><td bgcolor="61e31a"><a href="{$_SERVER['PHP_SELF']}?act=rep_web">Отчет посещения web страниц</a></td></tr>
                                        </table></br>

HTML;
?>
			</td>

			<td valign="top" align="left">
			<table border="0" cellspacing="10" cellpadding="0">
			<tr>
			<td valign="top" align="center">
<?php
			if($_GET['act'] == 'ch_pass'){include_once('../lib/ch_pass.php');}
			elseif($_GET['act'] == 'rep_traf'){include_once('../lib/rep_traf.php');}
			elseif($_GET['act'] == 'rep_web'){include_once('../lib/rep_web.php');}
                        else {echo "";}
                        //else {include_once('../lib/reports.php');}
?>
			</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>
