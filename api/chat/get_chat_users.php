<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$room_id = $_GET['room_id'];

$sql = "SELECT * FROM chat_user WHERE room_id='$room_id' AND is_in=1 ORDER BY created_at ASC";
$result = mq($sql);

// 채팅 참여자 데이터 보내기
$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($member = $result->fetch_assoc()) {
        $data = [
                'id'   => $member['id'],
                'roomId'   => $member['room_id'],
                'userId' => $member['user_id'],
                'isIn' => $member['is_in'],
                'token'   => $member['token'],
                'createdAt' => $member['created_at']
                ];
        array_push($array, $data);
}

echo json_encode($array);

?>