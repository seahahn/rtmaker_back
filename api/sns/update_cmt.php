<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];
$content = $_POST['content'];

// 들어온 값 있을 경우 DB에 피드 정보 수정
if(isset($content)) {
    // 피드 정보 수정
    $mq = mq("UPDATE feed_comment SET
    content = '$content'
    WHERE id = '$id'
    ");
} else {
    $mq = false;
}

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