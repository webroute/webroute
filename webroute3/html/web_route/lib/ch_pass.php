<?php
//###--- version 3.2.0 ---####//
include 'sql_to_chap.php';
function ch_password($user, $password)
{
    $result = 1;
    $db_host = 'localhost';
    $link = mysql_connect($db_host, 'webroute', 'wbr') or die(mysql_error());
    mysql_select_db('webroute', $link) or die(mysql_error());
    $query = "UPDATE  `webroute`.`users` SET  `password` =  '$password' WHERE  `users`.`login` ='$user' LIMIT 1";
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
$get_usr = "SELECT `id`, `login` FROM `users` order by `login`";
$g_usr = mysql_query($get_usr);
echo "<table align='center'><tr><td><div align=\"center\">\n";
echo "<form method=\"POST\">\n";
echo "&nbsp;<font color='blue'>Смена пароля для пользователя ".$_GET['usr'].".</font>\n<br/><br/>";
echo "новый пароль: <input type=\"text\" name=\"pass\">\n";
echo "<br/><br/>&nbsp\n";
echo "<input type=\"submit\" name=\"submit\" value=\"сменить пароль\">\n";
echo "<input type=\"submit\" name=\"cancel\" value=\"отмена\">\n";
echo "<input type='hidden' name='usr' value='".$_GET['usr']."'>";
echo "</form>\n";
echo "</div></td></tr></table>\n";
if (isset ($_POST['submit']))
{
    $user_id = $_POST['usr'];
    $pass = $_POST['pass'];
    $pass_ok = preg_match('/^[a-zA-Z0-9]+$/', $pass);
    if($pass_ok == 1)
    {
    ch_password($user_id, $pass);
    sql_to_chap();
    mysql_close($link);
    echo '<script language=\'javascript\'>setTimeout("window.location = \"/web_route/admin/index.php?act=v_usr\"", 100);</script>';
    }
    else
    {
        echo 'Пароль должен состоять из латинских букв и/или цифр';
    }
}

if (isset ($_POST['cancel']))
{
    echo '<script language=\'javascript\'>window.location = "/web_route/admin/index.php?act=v_usr"</script>';
}

}
else
{
    if ($_SESSION['role'] != 'admin')
        {
        if($_SESSION['user_ch_pass'] == 1)
        {
        echo "<table><tr><td>";
        echo "<div align=\"left\">\n";
        echo "<form method=\"POST\">\n";
        echo "&nbsp;Ваш новый пароль\n<br/>";
        echo "<input type=\"text\" name=\"pass\">\n";
        echo "<br/><br/>&nbsp\n";
        echo "<input type=\"submit\" name=\"submit\" value=\"сменить пароль\">\n";
        echo "<input type=\"submit\" name=\"cancel\" value=\"отмена\">\n";
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
        echo "</td></tr></table>";
        }
        else
        {
            echo "Смена пароля невозможна (запрещена в настройках).";
            //@header('Location: /web_route');
        }
    }
    else
    {
        @header('Location: /web_route');
    }
}
?>
