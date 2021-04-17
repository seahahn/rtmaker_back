<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    !empty($_GET['nick']) ? $nick = $_GET['nick'] : $nick = "";
    
    if($nick != ""){
        $result = mq("SELECT nick FROM user WHERE nick = '".$nick."'");
        $num = mysqli_num_rows($result);
        if($num==0){
            $ret['msg'] = "사용 가능한 닉네임입니다.";
            $ret['result'] = true;
        } else {
            $ret['msg'] = "중복된 닉네임입니다.";
            $ret['result'] = false;
        }
    }
    
    echo json_encode($ret);
?>