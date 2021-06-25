<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM sns_newsfeed WHERE id='$id'";
$result = mq($sql);

while($feed = $result->fetch_assoc()) {
    // 각각의 그룹 피드에 대하여 좋아요 수 및 사용자의 좋아요 여부와 댓글 수를 가져옴
    $get_likes = mq("SELECT * FROM feed_like WHERE feed_id = '$feed[id]' AND is_liked = 1");
    $like_count = mysqli_num_rows($get_likes);

    $is_liked = mq("SELECT * FROM feed_like WHERE feed_id = '$feed[id]' AND writer_id = '$user_id' AND is_liked = 1");
    mysqli_num_rows($is_liked) == 1 ? $liked = true : $liked = false;

    $get_cmts = mq("SELECT * FROM feed_comment WHERE feed_id = '$feed[id]'");
    $comment_count = mysqli_num_rows($get_cmts);

    $has_cmt = mq("SELECT * FROM feed_comment WHERE feed_id = '$feed[id]' AND writer_id = '$user_id'");
    mysqli_num_rows($has_cmt) >= 1 ? $cmt = true : $cmt = false;

    // 피드 데이터 보내기
    $data = [
        'id'   => $feed['id'],
        'writerId'   => $feed['writer_id'],
        'content' => $feed['content'],
        'images' => $feed['images'],
        'groupId'   => $feed['group_id'],
        'challengeId' => $feed['challenge_id'],
        'createdAt' => $feed['created_at'],
        'likeCount' => $like_count,
        'commentCount' => $comment_count,
        'liked' => $liked,
        'cmt' => $cmt
    ];
}

echo json_encode($data);

?>