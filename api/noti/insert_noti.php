<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$receiver_id = $_POST['receiver_id'];
$type = $_POST['type'];
$title = $_POST['title'];
$body = $_POST['body'];
$target = $_POST['target'];

// 들어온 값 있을 경우 DB에 피드 정보 저장
if(isset($receiver_id)) {
    // 피드 정보 저장
    $mq = mq("INSERT noti_item SET
    receiver_id = '$receiver_id',
    type = '$type',
    title = '$title',
    body = '$body',
    target = '$target'
    ");

} else {
    $mq = false;
}

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "저장되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "저장에 실패했습니다."
    ];
}

echo json_encode($response);

?>