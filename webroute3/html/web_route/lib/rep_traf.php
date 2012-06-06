<?php
echo "Выберите дату, месяц или год за который необходим отчет.";
echo "<br/><br/><table border=0><tr valign='top'><td>";
echo '<form method="POST"><select name="Day">';
echo '<option value="All">Весь</option>';
$i=1;
while ($i<=31)
{
    if($i < 10)
    {
    echo '<option value="0'.$i.'">'.$i.'</option>';
    }  else
    {
    echo '<option value="'.$i.'">'.$i.'</option>';
    }
    $i++;
}
echo '</select>';
echo '</td><td>';
echo '<select name="Mon">';
echo '<option value="01">Январь</option>';
echo '<option value="02">Февраль</option>';
echo '<option value="03">Март</option>';
echo '<option value="04">Апрель</option>';
echo '<option value="05">Май</option>';
echo '<option value="06">Июнь</option>';
echo '<option value="07">Июль</option>';
echo '<option value="08">Август</option>';
echo '<option value="09">Сентябрь</option>';
echo '<option value="10">Октябрь</option>';
echo '<option value="11">Ноябрь</option>';
echo '<option value="12">Декабрь</option>';
echo '<option value="All">Весь</option>';
echo '</select><br><br>';
echo '</td><td>';
echo '<select name="Year">';
if (date("n") > 6){
    $year = date("Y");
    echo '<option value="'.$year.'">'.$year.'</option>';
}else{
    $year = date("Y");
    $lyear = $year - 1;
    echo '<option value="'.$year.'">'.$year.'</option>';
    echo '<option value="'.$lyear.'">'.$lyear.'</option>';
}
echo '</select>';
echo '</td><td valign="top">';
echo '<input type="submit" name="submit" value="Показать">';
echo '</form>';
echo '</td></tr></table>';
if(isset($_POST['submit']))
{
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    mysql_set_charset('utf8',$link);
    $D = $_POST['Day'];
    $M = $_POST['Mon'];
    $Y = $_POST['Year'];

echo "Отчет по трафику за:".$D.'-'.$M.'-'.$Y.'.';
echo "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\"><tr><td>Логин</td><td>MB Вход.</td><td>MB Исход.</td></tr>";
$is_vis = "SELECT `value` FROM `config` WHERE `key`='view_except_traf'";
$is_vis = mysql_fetch_assoc(mysql_query($is_vis));
if($is_vis['value'] == 1){
    $all_users = "SELECT `login` FROM `users` ORDER BY `login`";
}else{
    $all_users = "SELECT DISTINCT `users`.`login` FROM `users` WHERE `users`.`login` NOT IN ( SELECT `report_except`.`userid` FROM `report_except`)";
}
$all_users = mysql_query($all_users);
$all_traf_in = 0;
$all_traf_out = 0;
while ($users=  mysql_fetch_assoc($all_users))
{
$login=$users['login'];
if($D == 'All' and $M != 'All')
{
    $date = $Y.'-'.$M.'%';
    $query = "SELECT `login`, sum(`in`), sum(`out`) FROM `traf` WHERE `date` LIKE '$date' AND `login`='$login'";
    $result = mysql_query($query);
    $result2 = mysql_fetch_assoc($result);
    $in = $result2['sum(`in`)'] / 1048576;
    $out = $result2['sum(`out`)'] / 1048576;
}
elseif($M == 'All')
{
   $date = $Y.'%';
   $query = "SELECT `login`, sum(`in`), sum(`out`) FROM `traf` WHERE `date` LIKE '$date' AND `login`='$login'";
   $result = mysql_query($query);
   $result2 = mysql_fetch_assoc($result);
   $in = $result2['sum(`in`)'] / 1048576;
   $out = $result2['sum(`out`)'] / 1048576;
}
 else
{
    $date = $Y.'-'.$M.'-'.$D;
    $query = "SELECT `login`, `in`, `out` FROM `traf` WHERE `date` LIKE '$date' AND `login`='$login'";
    $result = mysql_query($query);
    $result2 = mysql_fetch_assoc($result);
    $in = $result2['in'] / 1048576;
    $out = $result2['out'] / 1048576;
}
echo '<tr><td>'.$login.'</td><td>'.round($in,2).'</td><td>'.round($out,2).'</td></tr>';
$all_traf_in = $all_traf_in + $in;
$all_traf_out = $all_traf_out + $out;
}
echo "<tr><td>Всего</td><td>".round($all_traf_in,2)."</td><td>".round($all_traf_out,2)."</td></tr></table>";
echo "<table><tr><td><br><br><br>Данные статистики представлены лишь в качестве справочной информации, реальные данные по трафику рассчитываются провайдером.<br><br></td></tr></table>";
}
?>
