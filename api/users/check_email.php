<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    !empty($_GET['email']) ? $email = $_GET['email'] : $email = "";
    $regEmail = '/^[a-zA-Z]{1}[a-zA-Z0-9.\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]{1}[a-z.]+[a-z]{1})|([a-z]+))$/';

    if($email != ""){
        $result = mq("SELECT email FROM user WHERE email = '".$email."'");
        $num = mysqli_num_rows($result);
        if(!preg_match($regEmail, $email)) {
            $ret['msg'] = "올바르지 않은 이메일입니다.";
            $ret['result'] = false;
        }
        else if($num!=0){
            $ret['msg'] = "이미 가입된 이메일입니다.";
            $ret['result'] = false;
            $ret['overlap'] = true;
        } else {
            $ret['msg'] = "사용 가능한 이메일입니다.";
            $ret['result'] = true;
        }

        echo json_encode($ret);

    } else {
        $ret['msg'] = "이메일을 입력해주세요.";
        $ret['result'] = false;

        echo json_encode($ret);
    }
?>