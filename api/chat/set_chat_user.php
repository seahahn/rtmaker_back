<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$room_id = $_POST['room_id'];
$user_id = $_POST['user_id'];
$_POST['is_in'] == "true" ? $is_in = 1 : $is_in = 0;
$token = $_POST['token'];

// DB에 해당 채팅방에 사용자가 참여하고 있는지 아닌지에 대한 데이터 존재 여부 조회
$mq = mq("SELECT * FROM chat_user 
        WHERE room_id='$room_id' AND user_id='$user_id'");
$exist = mysqli_num_rows($mq);

if($exist == 0) {
    // 존재하고 있지 않으면 해당 채팅방에 참여하고 있다는 데이터 생성
    $mq = mq("INSERT chat_user SET
    room_id = '$room_id',
    user_id = '$user_id',
    is_in = '$is_in',
    token = '$token'
    ");

} else {
    // 존재하면 기존 데이터를 채팅방에 참여중인 것으로 수정
    $mq = mq("UPDATE chat_user SET
    is_in = '$is_in',
    token = '$token'
    WHERE room_id = '$room_id' AND user_id = '$user_id'");
}

// 사용자의 토큰값 갱신하기(재설치 등의 이유로 변동되었을 경우 대비)
mq("UPDATE chat_user SET
    token = '$token'
    WHERE user_id = '$user_id'");

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "수정되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "수정에 실패했습니다."
    ];
}

echo json_encode($response);

?>