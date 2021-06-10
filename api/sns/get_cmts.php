<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$feed_id = $_GET['feed_id'];

$sql = "SELECT * FROM feed_comment WHERE feed_id = '$feed_id' AND is_sub = 0 ORDER BY created_at DESC";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($cmt = $result->fetch_assoc()) {
    // 댓글 데이터 보내기
    $data = [
        'id'   => $cmt['id'],
        'writerId'   => $cmt['writer_id'],
        'feedId'   => $cmt['feed_id'],
        'content' => $cmt['content'],
        'image' => $cmt['image'],
        'isSub'   => false,
        'mainCmt' => $cmt['main_cmt'],
        'createdAt' => $cmt['created_at']
    ];
    array_push($array, $data);

    $sql = "SELECT * FROM feed_comment WHERE feed_id = '$feed_id' AND is_sub = 1 AND main_cmt = '$cmt[id]' ORDER BY created_at ASC";
    $sub_cmt_result = mq($sql);
    while($sub_cmt = $sub_cmt_result->fetch_assoc()) {
        // 댓글에 해당되는 대댓글 데이터 보내기
        $data = [
            'id'   => $sub_cmt['id'],
            'writerId'   => $sub_cmt['writer_id'],
            'feedId'   => $sub_cmt['feed_id'],
            'content' => $sub_cmt['content'],
            'image' => $sub_cmt['image'],
            'isSub'   => true,
            'mainCmt' => $sub_cmt['main_cmt'],
            'createdAt' => $sub_cmt['created_at']
        ];
        array_push($array, $data);
    }
}

echo json_encode($array);

function getSubCmts($feed_id, $main_cmt, $array) {
    $sql = "SELECT * FROM feed_comment WHERE feed_id = '$feed_id' AND is_sub = 1 AND main_cmt = '$main_cmt' ORDER BY created_at DESC";
    $sub_cmt_result = mq($sql);
    while($sub_cmt = $sub_cmt_result->fetch_assoc()) {
        // 댓글에 해당되는 대댓글 데이터 보내기
        $data = [
            'id'   => $sub_cmt['id'],
            'writerId'   => $sub_cmt['writer_id'],
            'feedId'   => $sub_cmt['feed_id'],
            'content' => $sub_cmt['content'],
            'image' => $sub_cmt['image'],
            'isSub'   => true,
            'mainCmt' => $sub_cmt['main_cmt'],
            'createdAt' => $sub_cmt['created_at']
        ];
        array_push($array, $data);
    }
}
?>