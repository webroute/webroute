<?php
if($_SESSION['role'] == 'admin'){
    $pwd = 'admin';
}elseif($_SESSION['role'] == 'statistic'){
    $pwd = 'statistics';
}
print <<<HTM2
<table>
<tr>
<td height="100%">
<a href="/web_route/$pwd/index.php?act=pptp-xp">Настройка подключения через PPTP для Windows XP.</a><br/>
<a href="/web_route/$pwd/index.php?act=pppoe-xp">Настройка подключения через PPPOE для Windows XP.</a><br/>
<a href="/web_route/$pwd/index.php?act=pppoe-7">Настройка подключения через PPPOE для Windows Vista / 7.</a><br/>
<a href="/web_route/$pwd/index.php?act=pptp-7">Настройка подключения через PPTP для Windows Vista / 7.</a><br/>
<a href="/web_route/$pwd/index.php?act=pppoe-mac">Настройка подключения через PPPOE для Mac OS X.</a><br/>
<a href="/web_route/$pwd/index.php?act=pptp-mac">Настройка подключения через PPTP для Mac OS X.</a><br/>
<a href="/web_route/$pwd/index.php?act=adming">Руководство по использованию системы.</a><br/>
<a href="http://webroute.org">Официальный сайт программы(форум/тех. поддержка).</a><br/>
</td>
</tr>
<tr>
<td>
</td></tr>
</table>
HTM2;
?>
