<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$writer_id = $_POST['writer_id'];
$content = $_POST['content'];
$content_type = $_POST['content_type'];
$room_id = $_POST['room_id'];

// 들어온 값 있을 경우 DB에 채팅 메시지 정보 저장
if(isset($content)) {
    // 메시지 정보 저장
    $mq = mq("INSERT chat_msg SET
    writer_id = '$writer_id',
    content = '$content',
    content_type = '$content_type',
    room_id = '$room_id'
    ");

} else {
    $mq = false;
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