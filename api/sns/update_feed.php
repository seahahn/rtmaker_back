<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];
$content = $_POST['content'];
$images = $_POST['images'];

// 들어온 값 있을 경우 DB에 피드 정보 저장
if(isset($content)) {
    // 피드 정보 저장
    $mq = mq("UPDATE sns_newsfeed SET
    content = '$content',
    images = '$images'
    WHERE id = '$id'
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