<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$group_id = $_POST['group_id'];
$user_id = $_POST['user_id'];
// $_POST['joined'] == "true" ? $joined = 1 : $joined = 0;

isset($user_id) ? $mq = mq("UPDATE sns_group_users SET 
                joined = 1
                WHERE group_id = '$group_id' AND user_id = '$user_id'
                ")
                : $mq = false;

$response;
$msg = "가입을 수락하였습니다";

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