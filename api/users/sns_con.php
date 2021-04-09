<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    $email = $_POST['email'];
    $pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
    $inway = $_POST['inway'];

    // 사용자 정보 변경
    mq("UPDATE user SET 
                    pw = '$pw',
                    inway = '$inway',
                    active = 1
                    WHERE email='$email'");   

    $ret['msg'] = "SNS 연동이 완료되었습니다.";
    $ret['result'] = true;

    echo json_encode($ret);
?>