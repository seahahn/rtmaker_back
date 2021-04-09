<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    $email = $_POST['email'];
    $pw = $_POST['pw'];

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mq($sql);

    $num_match = mysqli_num_rows($result);

    if(!$num_match){

        $ret['msg'] = "등록되지 않은 이메일입니다.";
        $ret['result'] = false;
        $ret['status'] = 0;

    } else {
        $ret = mysqli_fetch_array($result);
        $db_userpw = $ret['pw']; // DB에 저장된 사용자의 비밀번호 정보
        $db_active = $ret['active']; // 이메일 인증(계정 활성화) 여부
        $nick = $ret['nick'];

        if(!password_verify($pw, $db_userpw)){

            $ret['msg'] = "비밀번호가 틀립니다.";
            $ret['result'] = false;
            $ret['status'] = 1;

        } else if($db_active != 1) {

            $ret['msg'] = "이메일 인증을 해주세요.";
            $ret['result'] = false;
            $ret['status'] = 1;

        } else {

            $ret['msg'] = "좋은 하루입니다, ".$nick."님!";
            $ret['result'] = true;
            $ret['status'] = 1;

        }
    }

    echo json_encode($ret);
?>