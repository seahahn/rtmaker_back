<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM noti_item WHERE receiver_id = '$user_id' ORDER BY created_at DESC";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($noti = $result->fetch_assoc()) {
    // 댓글 데이터 보내기
    $data = [
        'id'   => $noti['id'],
        'receiverId'   => $noti['receiver_id'],
        'type'   => $noti['type'],
        'title' => $noti['title'],
        'body' => $noti['body'],
        'target' => $noti['target'],
        'createdAt' => $noti['created_at']
    ];
    array_push($array, $data);
}

echo json_encode($array);
?>