<?php
//###--- version 3.2.0 ---####//
session_start();
if ($_SESSION['role'] != 'statistic')
	{
	@header('Location: /web_route');
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>webroute</title>
    <link rel="shortcut icon"href="../img/icon.ico">
<link href="/web_route/untitled.css" rel="stylesheet" type="text/css">
<script src="/web_route/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#jsddm > li').bind('mouseover', jsddm_open)
   $('#jsddm > li').bind('mouseout',  jsddm_timer)
   $('#jsddm2 > li').bind('mouseover', jsddm_open)
   $('#jsddm2 > li').bind('mouseout',  jsddm_timer)
   $('#jsddm3 > li').bind('mouseover', jsddm_open)
   $('#jsddm3 > li').bind('mouseout',  jsddm_timer)
   $('#jsddm4 > li').bind('mouseover', jsddm_open)
   $('#jsddm4 > li').bind('mouseout',  jsddm_timer)
   $('#jsddm5 > li').bind('mouseover', jsddm_open)
   $('#jsddm5 > li').bind('mouseout',  jsddm_timer)
   });

document.onclick = jsddm_close;
</script>
</head>
<body class="tmpl2">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<!--- head--->
<tr><td >

<table border="0" cellpadding="0" cellspacing="0" width="100%" cols="3" frame="void" >
<tr>
<td width="160"><img src="/web_route/img/logo1.jpg" height="47" width="160"></td>
<td width="100%"><img src="/web_route/img/logo2.jpg" height="47" width="100%"></td>
<td width="21"><img src="/web_route/img/logo3.jpg" height="47" width="21"></td>
</tr>
</table>

<!--- end of head--->
</td></tr>


<!--- menu --->
<tr>
<td width="100%">

<table border="0" cellpadding="0" cellspacing="0">
<tr>

<td><img src="/web_route/img/m_left_border.jpg" height="32"></td>
<td><img src="/web_route/img/m_left__border.png" height="32"></td>
<td>
<?php
print <<<HTML
<ul id="jsddm">
    <li><a href="">Пользователи</a>
        <ul>
            <li><a href="{$_SERVER['PHP_SELF']}?act=ch_pass">Изменить пароль</a></li>
        </ul>
    </li>
</ul>
</td>

<td>
<ul id="jsddm3">
    <li><a href="">Отчеты</a>
        <ul>
            <li><a href="{$_SERVER['PHP_SELF']}?act=rep_traf">Отчет по трафику</a></li>
            <li><a href="{$_SERVER['PHP_SELF']}?act=rep_web">Отчет посещения web</a></li>
        </ul>
    </li>
</ul>
</td>

<td>
<ul id="jsddm4">
    <li><a href="">Дополнительно</a>
        <ul>
            <li><a href="{$_SERVER['PHP_SELF']}?act=instructions">Инструкции</a></li>
            <li><a href="{$_SERVER['PHP_SELF']}?act=phpsysinfo">Информация об оборудовании</a></li>
            <li><a href="{$_SERVER['PHP_SELF']}?act=about">О программе</a></li>
        </ul>
    </li>
</ul>
</td>
<td>
    <ul id="jsddm6"><li><a href="{$_SERVER['PHP_SELF']}?act=exit">Выход из системы</a></li></ul>
HTML;
?>
</td>

<td width="100%" ><img src="/web_route/img/menu_space.png" width="100%" height="32"></td>
<td><img src="/web_route/img/menu_right.png" height="32"></td>
<td><img src="/web_route/img/menu_right_border.jpg" height="32"></td>
</tr>
</table>

</td>
<!--- end of menu--->
</tr>
<!--- main--->
<tr>
<td width="100%" height="100%">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr height="100%">

<td width="10%" style="background:url(/web_route/img/bg.png)">

	<table cellpadding="0" cellspacing="0" height="100%" width="100%" border="0">
	<tr height="100%">
	<td height="100%">
	<img src="/web_route/img/m_left_border.jpg" height="100%" width="10">
	</td>
	<td width="100%" height="100%">
	</td>
	</tr>
	</table>

</td>

<td width="80%" style="background:url(/web_route/img/bg.png)" height="100%" valign="top">
<img src="/web_route/img/bg.png" height="70">

<div  class="block-round">
  <span class="r1"></span><span class="r2"></span><span class="r3"></span><span class="r4"></span>
  <div class="block-round-content" style="background-color:#EDF3FE" align="center">

<?php
                     if(isset ($_GET['act'])){
			if($_GET['act'] == 'ch_pass'){include_once('../lib/ch_pass.php');}
			elseif($_GET['act'] == 'rep_traf'){include_once('../lib/rep_traf.php');}
			elseif($_GET['act'] == 'rep_web'){include_once('../lib/rep_web.php');}
            elseif($_GET['act'] == 'instructions'){include_once('../lib/instructions.php');}
            elseif($_GET['act'] == 'about'){include_once('../lib/about.php');}
            elseif($_GET['act'] == 'phpsysinfo'){include_once('../lib/phpsysinfo.php');}
            elseif($_GET['act'] == 'pptp-xp'){include_once('../instructions/pptp-xp.html');}
            elseif($_GET['act'] == 'pppoe-xp'){include_once('../instructions/pppoe-xp.html');}
            elseif($_GET['act'] == 'pptp-7'){include_once('../instructions/pptp-7.html');}
            elseif($_GET['act'] == 'pppoe-7'){include_once('../instructions/pppoe-7.html');}
            elseif($_GET['act'] == 'pptp-mac'){include_once('../instructions/pptp-mac.html');}
            elseif($_GET['act'] == 'pppoe-mac'){include_once('../instructions/pppoe-mac.html');}
            elseif($_GET['act'] == 'adming'){include_once('../instructions/statistics.html');}
            elseif($_GET['act'] == 'exit')
            {
                session_destroy();
                echo '<script type="text/javascript"> location.replace("../");</script>';
            }
			else {include_once('../lib/about.php');}
                     }else{
                        $_GET['act'] = 0;
                        include_once '../lib/rep_traf.php';
                     }
?>

  </div>
  <span class="r4"></span><span class="r3"></span><span class="r2"></span><span class="r1"></span>
  </div>

</td>

<td width="10%" style="background:url(/web_route/img/bg.png)" height="100%">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
	<td height="100%" width="100%">
	<img src="/web_route/img/menu_right_border.jpg"  height="100%" width="10" align="right">
	</td>
	</tr>
	</table>

</td>

</tr>
</table>
</td>
<!--- end of main--->
</tr>
</table>
</body>
</html>
