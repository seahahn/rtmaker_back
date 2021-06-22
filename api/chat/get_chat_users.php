<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$room_id = $_GET['room_id'];

$mq = mq("SELECT * FROM chat_user 
        WHERE room_id='$room_id' AND is_in=1");

// 채팅방 데이터 보내기
$result = $mq->fetch_assoc();
$data = [
        'id'   => $result['id'],
        'roomId'   => $result['room_id'],
        'userId' => $result['user_id'],
        'isIn' => $result['is_in'],
        'token'   => $result['token'],
        'createdAt' => $result['created_at']
        ];

echo json_encode($data);

?>