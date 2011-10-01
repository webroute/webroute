<?php
include 'sql_to_chap.php';
function ch_password($user, $password)
{
    $result = 1;
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    $query = "UPDATE  `webroute`.`users` SET  `password` =  '$password' WHERE  `users`.`id` ='$user' LIMIT 1";
    mysql_query($query) or $result = 0;
    return $result;
}

function ch_password_usr($user, $password)
{
    $result = 1;
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    $query = "UPDATE  `webroute`.`users` SET  `password` =  '$password' WHERE  `users`.`login` ='$user' LIMIT 1";
    mysql_query($query) or $result = 0;
    return $result;
}


if ($_SESSION['role'] == 'admin')
{
$db_host = 'localhost';
$link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
mysql_select_db('webroute', $link) or die(mysql_error());
$get_usr = "SELECT `id`, `login` FROM `users`";
$g_usr = mysql_query($get_usr);
echo "<table><tr><td><div align=\"left\">\n";
echo "<form method=\"POST\">\n";
echo "&nbsp;пользователь\n<br/>";
echo "<select name=\"user_id\" size=\"1\">\n";
echo "<option disabled>выберите пользователя</option>\n";
while($usr = mysql_fetch_assoc($g_usr))
  {
    echo "<option value=\"" . $usr['id'] . "\">" . $usr['login'] . "</option>\n";
  }
echo "</select><br/>\n";
echo "&nbsp;новый пароль\n<br/>";
echo "<input type=\"text\" name=\"pass\">\n";
echo "<br/><br/>&nbsp\n";
echo "<input type=\"submit\" name=\"submit\" value=\"сменить пароль\">\n";
echo "</form>\n";
echo "</div></td></tr></table>\n";
if (isset ($_POST['submit']))
{
    $user_id = $_POST['user_id'];
    $pass = $_POST['pass'];
    //$user_ok = preg_match('/^[a-zA-Z0-9]+$/', $login);
    $pass_ok = preg_match('/^[a-zA-Z0-9]+$/', $pass);
    if($pass_ok == 1)
    {
    ch_password($user_id, $pass);
    sql_to_chap();
    mysql_close($link);
    }
    else
    {
        echo 'Пароль должен состоять из латинских букв и/или цифр';
    }
}

}
else
{
    
    if ($_SESSION['role'] == 'statistic' or $_SESSION['role'] == 'user')
        {
        if($_SESSION['user_ch_pass'] == 1)
        {
        echo "<div align=\"left\">\n";
        echo "<form method=\"POST\">\n";
        echo "&nbsp;Ваш новый пароль\n<br/>";
        echo "<input type=\"text\" name=\"pass\">\n";
        echo "<br/><br/>&nbsp\n";
        echo "<input type=\"submit\" name=\"submit\" value=\"сменить пароль\">\n";
        echo "</form>\n";
        echo "</div>\n";
        if (isset ($_POST['submit']))
            {
                $user = $_SESSION['login'];
                $pass = $_POST['pass'];
                $pass_ok = preg_match('/^[a-zA-Z0-9]+$/', $pass);
                if($pass_ok == 1)
                {
                ch_password_usr($user, $pass);
                sql_to_chap();
                }
                else
                {
                    echo 'Пароль должен состоять из латинских букв и/или цифр';
                }
            }
        }
        else
        {
            @header('Location: /web_route');
        }

    }
    else
    {
        @header('Location: /web_route');
    }

}
?>
