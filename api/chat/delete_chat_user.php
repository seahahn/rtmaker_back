<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];

// $mq = mq("DELETE FROM chat_user WHERE user_id='$user_id' AND room_id='$room_id'");

// 데이터를 통째로 삭제하는 것이 아닌 채팅방 입장 여부만 변경함
$mq = mq("UPDATE chat_user SET is_in = 0 WHERE user_id='$user_id' AND room_id='$room_id'");

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "삭제되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "삭제에 실패했습니다."
    ];
}

echo json_encode($response);

?>

?>