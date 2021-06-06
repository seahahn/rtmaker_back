<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$group_id = $_POST['group_id'];
$user_id = $_POST['user_id'];
$_POST['joined'] == "true" ? $joined = 1 : $joined = 0;

isset($user_id) ? $mq = mq("INSERT sns_group_users SET 
                group_id = '$group_id',
                user_id = '$user_id',
                joined = '$joined'
                ")
                : $mq = false;

$_POST['joined'] == "true" ? $msg = "가입 완료!" : $msg = "가입 신청 완료!";
$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => $msg
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "가입에 실패했습니다."
    ];
}

echo json_encode($response);

?>