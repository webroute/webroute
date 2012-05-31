<?php
    function sql_to_skipuser(){
        $file = fopen('/etc/lightsquid/skipuser.cfg', 'w');
        $select_except = "SELECT `userid` FROM `report_except`";
        $ress = mysql_query($select_except);
        $select_ppp_net = "SELECT `value` FROM `config` where `key`='ppp_network'";
        $result_ppp = mysql_query($select_ppp_net);
        $mass_ppp = mysql_fetch_assoc($result_ppp);
        $ppp_net = $mass_ppp['value'];
        while($res = mysql_fetch_assoc($ress)){
            $usip = "SELECT `ip` FROM `users` WHERE `login`='".$res['userid']."'";
            $sss = mysql_fetch_assoc(mysql_query($usip));
            $uip = $ppp_net.$sss['ip'];
            fwrite($file, $uip."\n");
        }
        fclose($file);
    }

    function add_skip_user($user){
        $query = "INSERT INTO `report_except` (`userid`) values ('$user')";
        mysql_query($query);
        sql_to_skipuser();
    }

    function del_skip_user($id){
        $quer = "DELETE FROM `report_except` WHERE `id`='$id'";
        mysql_query($quer);
        sql_to_skipuser();
    }
?>