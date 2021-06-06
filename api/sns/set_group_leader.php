<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$group_id = $_POST['group_id'];
$user_id = $_POST['user_id'];

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
if(isset($group_id)) {
    $mq = mq("UPDATE sns_group SET
    leader_id = '$user_id'
    WHERE id = '$group_id'
    ");
} else {
    $mq = false;
}

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "리더가 변경되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "변경에 실패했습니다."
    ];
}

echo json_encode($response);

?>