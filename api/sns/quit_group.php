<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$group_id = $_POST['group_id'];
$user_id = $_POST['user_id'];

// 그룹 가입 여부 확인. 가입되어 있었거나, 가입 신청을 했었거나 둘 중 하나임
$mq = mq("SELECT * FROM sns_group_users WHERE group_id = '$group_id' AND user_id = '$user_id' AND joined = 1");
mysqli_num_rows($mq) == 1 ? $msg = "그룹을 탈퇴하였습니다" : $msg = "가입 신청을 취소하였습니다";

$mq = mq("DELETE FROM sns_group_users WHERE group_id = '$group_id' AND user_id = '$user_id'");

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => $msg
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "오류가 발생했습니다"
    ];
}

echo json_encode($response);

?>