<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$writer_id = $_POST['writer_id'];
$feed_id = $_POST['feed_id'];
$feed_writer_id = $_POST['feed_writer_id'];
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
    // $mq_feed = mq("SELECT * FROM sns_newsfeed WHERE id='$feed_id'");
    // $ret_feed = mysqli_fetch_array($mq_feed);
    // $feed_content = $ret_feed['content'];
    // $images = $ret_feed['images'];

    $mq_feed_writer = mq("SELECT token FROM user WHERE id = '$feed_writer_id'");
    $ret_feed_writer = mysqli_fetch_array($mq_feed_writer);
    $feed_writer_token = $ret_feed_writer['token'];

    $is_sub == 1 ? $sub_cmt = true : $sub_cmt = false;

    if($mq_feed_writer) {
        if($sub_cmt) { // 대댓글인 경우 대댓글이 달린 댓글 작성자와 피드 작성자 둘 모두에게 알림을 보냄
            $mq_cmt_writer_id = mq("SELECT writer_id FROM feed_comment WHERE main_cmt = '$main_cmt'");
            $ret_cmt_writer_id = mysqli_fetch_array($mq_cmt_writer_id);
            $cmt_writer_id = $ret_cmt_writer_id['writer_id'];

            $mq_cmt_writer = mq("SELECT token FROM user WHERE id = '$cmt_writer_id'");
            $ret_cmt_writer = mysqli_fetch_array($mq_cmt_writer);
            $cmt_writer_token = $ret_cmt_writer['token'];

            $response = [
                'result'   => true,
                'msg' => "작성되었습니다.",
                'subCmt' => $sub_cmt,
                'token' => $feed_writer_token,
                'mainCmtWriterToken' => $cmt_writer_token,
                'content' => $content,
                'images' => $image
            ];
        } else { // 그냥 댓글이면 피드 작성자에게만 알림 보냄
            $response = [
                'result'   => true,
                'msg' => "작성되었습니다.",
                'subCmt' => $sub_cmt,
                'token' => $feed_writer_token,
                'content' => $content,
                'images' => $image
            ];
        }
    }
} else {
    $response = [
        'result'   => false,
        'msg' => "작성에 실패했습니다."
    ];
}

echo json_encode($response);

?>