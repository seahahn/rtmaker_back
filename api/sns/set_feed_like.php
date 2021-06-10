<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$feed_id = $_POST['feed_id'];
$writer_id = $_POST['writer_id'];
$_POST['is_liked'] == "true" ? $is_liked = 1 : $is_liked = 0;

// 들어온 값 있을 경우 DB에 피드 좋아요 정보 저장
if(isset($feed_id)) {
    // 이전에 저장되었던 좋아요 데이터가 있는지 확인 후 있으면 그 정보를 수정, 없으면 새로 생성
    $check = mq("SELECT * FROM feed_like WHERE feed_id = '$feed_id' AND writer_id = '$writer_id'");
    $count = mysqli_num_rows($check);

    if($count == 0) {
        // 좋아요 정보 저장
        $mq = mq("INSERT feed_like SET
        feed_id = '$feed_id',
        writer_id = '$writer_id',
        is_liked = '$is_liked'
        ");
    } else {
        // 좋아요 정보 수정
        $mq = mq("UPDATE feed_like SET
        is_liked = '$is_liked'
        WHERE feed_id = '$feed_id' AND writer_id = '$writer_id'
        ");
    }
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