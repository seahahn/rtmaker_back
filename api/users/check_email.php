<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    !empty($_GET['email']) ? $email = $_GET['email'] : $email = "";
    $regEmail = '/^[a-zA-Z]{1}[a-zA-Z0-9.\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]{1}[a-z.]+[a-z]{1})|([a-z]+))$/';

    if($email != ""){
        $result = mq("SELECT * FROM user WHERE email = '".$email."'");
        $num = mysqli_num_rows($result);
        $user = mysqli_fetch_array($result);
        $inway = $user['inway'];
        if(!preg_match($regEmail, $email)) {
            $ret['msg'] = "올바르지 않은 이메일입니다.";
            $ret['result'] = false;
            $ret['overlap'] = false;
        }
        else if($num != 0 && $inway != 'etc'){ // 이미 SNS를 통해 서비스 이용 중인 경우
            $ret['msg'] = "";
            $ret['result'] = true;
            $ret['overlap'] = true;
        }
        else if($num!=0){
            $ret['msg'] = "이미 가입된 이메일입니다.";
            $ret['result'] = false;
            $ret['overlap'] = true;
        }
        else {
            $ret['msg'] = "사용 가능한 이메일입니다.";
            $ret['result'] = true;
            $ret['overlap'] = false;
        }

    } else {
        $ret['msg'] = "이메일을 입력해주세요.";
        $ret['result'] = false;
        $ret['overlap'] = false;
    }

    echo json_encode($ret);

?>