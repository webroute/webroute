<?php
if ($_SESSION['role'] != 'admin')
	{
	@header('Location: /web_route');
	}
else
{
    if(isset($_POST['submit'])){
        $link = mysql_connect('localhost', 'webroute', 'wbr') or die(mysql_error());
        mysql_select_db('webroute', $link) or die(mysql_error());
        mysql_set_charset('utf8',$link);
        include_once 'sql_to_redirector.php';
        $banform = $_POST['ban_form'];
        $unbanmail = trim($_POST['unban_mail']);
        $needmail = $_POST['need_mail'];
        $qu1 = "UPDATE `webroute`.`config` SET `value` = '".$banform."' WHERE `config`.`key`='rej_ban_form'";
        $qu2 = "UPDATE `webroute`.`config` SET `value` = '".$unbanmail."' WHERE `config`.`key`='rej_unban_mail'";
        $qu3 = "UPDATE `webroute`.`config` SET `value` = '".$needmail."' WHERE `config`.`key`='rej_need_usr_mail'";
        mysql_query($qu1);
        if($unbanmail != '')mysql_query($qu2);
        mysql_query($qu3);
        sql_to_redirector();
        echo "<script language='javascript'>window.location = \"/web_route/admin/index.php?act=unban_pref\"</script>";
    }
    echo '<table><tr><td>';
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);
    $q1 = "SELECT `value` FROM `config` WHERE `key` = 'rej_ban_form'";
    $q2 = "SELECT `value` FROM `config` WHERE `key` = 'rej_unban_mail'";
    $q3 = "SELECT `value` FROM `config` WHERE `key` = 'rej_need_usr_mail'";
    $ban_form = mysql_fetch_assoc(mysql_query($q1));
    $unban_mail = mysql_fetch_assoc(mysql_query($q2));
    $need_usr_mail = mysql_fetch_assoc(mysql_query($q3));
    if($ban_form['value'] == 0){$a = 'checked'; $b = '';}else{$a = ''; $b = 'checked';}
    if($need_usr_mail['value'] == 0){$c = 'checked'; $d = '';}else{$c = ''; $d = 'checked';}
    echo "<form method='post' name='ban_pref'>";
    echo '<br><br>Показывать форму заявки на разблокировку сайта?<br>';
    echo "<input type='radio' name='ban_form' value='0'".$a.">Не показывать<br>";
    echo "<input type='radio' name='ban_form' value='1'".$b.">Показывать<br>";
    echo '<br>Ведите адрес, куда будут отправляться заявки. Текущий адрес: '.$unban_mail['value'].'<br>';
    echo "<input size=30 type='text' name='unban_mail'><br>";
    echo '<br>Требовать от пользователя обратный e-mail?<br>';
    echo "<input type='radio' name='need_mail' value='1'".$d.">Да<br>";
    echo "<input type='radio' name='need_mail' value='0'".$c.">Нет<br><input type=submit name=submit value=сохранить></form>";
    echo '</td></tr></table>';
}
?>
