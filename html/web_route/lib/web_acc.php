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
$sel_cat = "SELECT * FROM `rej_categories`";
$cat = mysql_query($sel_cat);
echo "<table border='1' cellspacing=\"0\" cellpadding=\"5\" width='800'>\n";
echo "<tr><td>категория</td><td>краткое описание</td><td>включена?</td><td>действие</td></tr>";
while($categ = mysql_fetch_assoc($cat))
{
    echo "<tr><td>";
    echo $categ['name'];
    echo "</td><td>";
    echo $categ['description'];
    echo "</td><td>";
    if ($categ['enabled'] == 1)
        {
            echo "Да";
        }
        else
        {
            echo "Нет";
        }
   echo "</td><td>";
   if($categ['enabled'] == 1)
   {
       echo "<a href=\"";
       //echo $_SERVER['PHP_SELF'];
       echo "/web_route/lib/act_wc.php?dwc=";
       echo $categ['id'];
       echo "\">отключить</a>";
   }
   else
   {
       echo "<a href=\"";
       //echo $_SERVER['PHP_SELF'];
       echo "/web_route/lib/act_wc.php?ewc=";
       echo $categ['id'];
       echo "\">включить</a>";
   }

   echo "</td></tr>\n";
}

echo '</table>';

}
?>
