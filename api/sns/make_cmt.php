<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$writer_id = $_POST['writer_id'];
$feed_id = $_POST['feed_id'];
$content = $_POST['content'];
$image = $_POST['image'];
$_POST['is_sub'] == "true" ? $is_sub = 1 : $is_sub = 0;
$main_cmt = $_POST['main_cmt'];

// 들어온 값 있을 경우 DB에 피드 정보 저장
if(isset($content)) {
    // 피드 정보 저장
    $mq = mq("INSERT feed_comment SET
    writer_id = '$writer_id',
    feed_id = '$feed_id',
    content = '$content',
    image = '$image',
    is_sub = '$is_sub',
    main_cmt = '$main_cmt'
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