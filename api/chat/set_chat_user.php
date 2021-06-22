<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$room_id = $_POST['room_id'];
$user_id = $_POST['user_id'];
$_POST['is_in'] == "true" ? $is_in = 1 : $is_in = 0;
$token = $_POST['token'];

$mq = mq("SELECT * FROM chat_user 
        WHERE room_id='$room_id' AND user_id='$user_id'");
$exist = mysqli_num_rows($mq);

if($exist == 0) {
    $mq = mq("INSERT chat_user SET
    room_id = '$room_id',
    user_id = '$user_id',
    is_in = '$is_in',
    token = '$token'
    ");

} else {
    $mq = mq("UPDATE chat_user SET
    is_in = '$is_in',
    token = '$token'
    WHERE room_id = '$room_id' AND user_id = '$user_id'");
}

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "작성되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "작성에 실패했습니다."
    ];
}

echo json_encode($response);

?>