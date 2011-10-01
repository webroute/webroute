<?php
echo "Выберите дату, месяц или год за который необходим отчет.";
echo "<br/><br/><table border=0><tr><td>";
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
$year=2011;
for ( $i=0; $i<=10; $i++ )
{
    $new_year=$year+$i;
    echo '<option value="'.$new_year.'">'.$new_year.'</option>';
}
echo '</select>';
echo '<br><br></td><td>';
echo '<button type="submit" name="submit">Показать</button>';
echo '</form>';
echo '<br><br></td></tr></table>';
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
$all_users = "SELECT `login` FROM `users`";
$all_users = mysql_query($all_users);

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
}
echo "</table>";
}

?>
