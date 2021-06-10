<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$writer_id = $_POST['writer_id'];
$content = $_POST['content'];
$images = $_POST['images'];
$group_id = $_POST['group_id'];
$challenge_id = $_POST['challenge_id'];

// 들어온 값 있을 경우 DB에 피드 정보 저장
if(isset($content)) {
    // 피드 정보 저장
    $mq = mq("INSERT sns_newsfeed SET
    writer_id = '$writer_id',
    content = '$content',
    images = '$images',
    group_id = '$group_id',
    challenge_id = '$challenge_id'
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