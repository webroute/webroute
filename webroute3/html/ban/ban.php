<?php
if(isset($_POST['submit'])){
    if(isset($_POST['mail'])){
        $mail = substr(htmlspecialchars(trim($_POST['mail'])), 0, 100);
    }else{
        $mail = 'webroute';
    }
    $reason = htmlspecialchars(trim($_POST['reason']));
    $is_ok = preg_match('/^(.+@.+\..+|)$/', $mail);
    $need_mail = $_POST['need_mail'];
    if($need_mail == 0){
        $is_ok = 1;
    }
    if($reason == ''){
        echo '<font color="#8a2be2" size="15px">Не указана причина.</font>';
        $is_ok = 2;
    }
    if($is_ok == 1){
        $ip2 = $_POST['ip'];
        $section2 = $_POST['section'];
        $url2 = $_POST['url'];
        $db_host = 'localhost';
		$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
		mysql_select_db('webroute', $link) or die(mysql_error());
        mysql_set_charset('utf8',$link);
        $query = "SELECT `value` FROM `webroute`.`config` WHERE `key` = 'rej_unban_mail'";
        $quer = mysql_fetch_assoc(mysql_query($query));
        $to = $quer['value'];
        $title = 'request for unblocking';
        mail($to, $title, '<<reason>> '.$reason."\n".'<<ip>> '.$ip2."\n".'<<category>> '.$section2."\n".'<<url>> '.$url2, 'From:'.$mail);
        echo 'Спасибо! Ваша заявка отправлена.';
    }elseif($is_ok == 0){
        echo '<font color="#8a2be2" size="15px">Адрес электронной почты введен не верно или не введен вообще.</font>';
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Доступ запрещен!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
<h2><font color="red">Доступ к сайту ограничен системой контент-фильтрации</font></h2>
<?php
$ip = $_GET['ip'];
$url = $_GET['url'];
$section = $_GET['sec'];
if(isset($_GET['nm']) and $_GET['nm'] == 0){
    $need_mail = 0;
}else{
    $need_mail = 1;
}
if($section == 'porno'){
    $description = "Сайты или разделы сайтов, содержащие изображения порнографического и эротического характера. К этой категории так же относятся: Сайты связанные с секс услугами (проституция, эротический массаж и т.д.); Сайты эскорт агентств; Сайты секс-шопов;";
}elseif($section == 'baner'){
    $description = 'Реклама в сети интернет.';
}elseif($section == 'chats'){
    $description = 'Чаты, в которых можно общаться через интернет используя веб-браузер, либо специальное клиент-серверное приложение.';
}elseif($section == 'audio-video'){
    $description = 'Звуковые и видео файлы, сайты, содержащие каталоги аудио и видео материалов и/или занимающиеся распространением аудио/видео материалов.';
}elseif($section == 'avto-moto'){
    $description = 'Сайты об автомобилях и мотоциклах, в том числе сайты производителей, новости, обзоры и форумы.';
}elseif($section == 'dating'){
    $description = 'Сайты знакомств. Главный критерий сайта, для попадания в эту категорию - база пользователей, желающих познакомиться, с возможностью поиска по ней и возможностью добавить себя в неё.';
}elseif($section == 'extremism_rf'){
    $description = 'Сайты, входящие в Федеральный список экстремистских материалов.';
}elseif($section == 'icq'){
    $description = 'Сервера в интернете, позволяющие общаться при помощи программ обмена сообщениями (ICQ, IRC, AIM, Skype, Yahoo, Jabber, Gadu-Gadu и др.).';
}elseif($section == 'online-games'){
    $description = 'Сервера в интернете, при помощи которых можно играть в игры, используя веб-браузер, либо специальное клиент-серверное приложение.';
}elseif($section == 'phishing'){
    $description = 'Сайты, копирующие оригинальный сайт, с целью получения пользовательских данных оригинального сайта, например логина и пароля.';
}elseif($section == 'photogallery'){
    $description = 'Различные сетевые фотогалереи и фотосайты.';
}elseif($section == 'socnet'){
    $description = 'Сайты социальных сетей. Например: vkontakte и odnoklassniki.';
}elseif($section == 'spyware'){
    $description = 'Сайты и сервера, содержащиеся в коде spyware софта, используемые этим софтом для передачи пользовательских данных или занимающиеся распространение такого софта.';
}elseif($section == 'torrents'){
    $description = 'Сайты, содержащие торрент файлы или ссылки на них, а так же сервера, обеспечивающие передачу данный по протоколу BitTorrent.';
}elseif($section == 'virus-detect'){
    $description = 'Урлы, содержавшиеся в теле вирусов.';
}elseif($section == 'quick_ban'){
    $description = 'Данная категория содержит список сайтов запрещенных к посещению в данной организации';
}elseif($section == 'warez'){
    $description = 'В данную категорию попадают сайты предлагающие скачать "пиратское" , нелицензионное програмное обеспечение.';
}elseif($section == 'web-mail'){
    $description = 'Сайты, позволяющие принимать/отправлять почту через веб-интерфейс.';
}elseif($section == 'web-proxy'){
    $description = 'Cлужба в компьютерных сетях, позволяющая клиентам выполнять косвенные запросы к другим сетевым службам через веб-интерфейс. Например чтобы попасть на запрещенный сайт.';
}elseif(preg_match('den_*',$section) == true){
    $description = 'Личный запрет для конкретного пользователя.';
}elseif($section == 'jobsearch'){
    $description = 'Сайты для поиска работы и персонала(рекрутинг).';
}elseif($section == 'ip_addr'){
    $description = 'Доступ к сайтам по ip адресам запрещен.';
}else{
    $description = "Данная категория неизвестна.";
}
$a = "<h3>Доступ к сайту запрещен.<br>Данный сайт попадает под запрет категории ";
echo $a;
echo $section;
echo ".</h3>";
echo '<font color="#FF0000">Описание категории:<br></font>';
echo $section;
echo ' - ';
echo $description;

if(isset($_GET['ac']) and $_GET['ac'] == 1){
    if($need_mail == 1){
print <<<html1
<p><font color="#FF0000">Почему так произошло?</font><br> Очевидно запрошенный вами веб-узел был уличен в распространении запрещенного контента.
<p><font color="#FF0000">Возможна ли ошибка?</font><br> Каждый из адресов проверялся не менее 30 раз различными людьми прежде чем попасть в базу, и несмотря на это ошибки возможны. Сайт может сменить профиль деятельности, владельца и т.п. Если вы обнаружили ошибку воспользуйтесь формой ниже.
<form name="unban" method="post">
<font color="#FF0000">Ваш e-mail адрес*:</font><br>
<input type="text" name="mail"><br><br>
<font color="#FF0000">Причина по которой Вы хотите посещать этот сайт*:</font><br>
<textarea name="reason" cols="40" rows="3">
</textarea><br>
&nbsp;&nbsp;&nbsp;*Поля обязательные для заполнения.
html1;
    }
    if($need_mail == 0){
print <<<html2
<p><font color="#FF0000">Почему так произошло?</font><br> Очевидно запрошенный вами веб-узел был уличен в распространении запрещенного контента.
<p><font color="#FF0000">Возможна ли ошибка?</font><br> Каждый из адресов проверялся не менее 30 раз различными людьми прежде чем попасть в базу, и несмотря на это ошибки возможны. Сайт может сменить профиль деятельности, владельца и т.п. Если вы обнаружили ошибку воспользуйтесь формой ниже.
<form name="unban" method="post">
<font color="#FF0000">Причина по которой Вы хотите посещать этот сайт*:</font><br>
<textarea name="reason" cols="40" rows="3">
</textarea><br>
&nbsp;&nbsp;&nbsp;*Поля обязательные для заполнения.
html2;
    }
echo '<input type="hidden" name="ip" value="';
echo $ip;
echo '">';

echo '<input type="hidden" name="url" value="';
echo $url;
echo '">';

echo '<input type="hidden" name="section" value="';
echo $section;
echo '">';

echo '<input type="hidden" name="need_mail" value="';
echo $need_mail;
echo '">';

echo '<br><input type="submit" name="submit" value="отправить">';
echo '</form>';
}
?>
</body>
</html>
