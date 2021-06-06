<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM sns_group WHERE id='$id'";
$result = mq($sql);

while($group = $result->fetch_assoc()) {
    // 가져온 그룹에 사용자가 가입되어 있는지 확인
    $mq = mq("SELECT * FROM sns_group_users WHERE group_id = '$id' AND user_id = '$user_id' AND joined = 1");
    mysqli_num_rows($mq) == 1 ? $joined = true : $joined = false;
    if(!$joined) {
        $mq = mq("SELECT * FROM sns_group_users WHERE group_id = '$id' AND user_id = '$user_id' AND joined = 0");
        mysqli_num_rows($mq) == 1 ? $applied = true : $applied = false;
    } else {
        $applied = false;
    }

    // 가져온 그룹에 가입된 사용자 수 확인
    $mq = mq("SELECT * FROM sns_group_users WHERE group_id = '$id' AND joined = '1'");
    $member_count = mysqli_num_rows($mq);
    
    // 그룹 데이터 보내기
    $group['on_public'] == 1 ? $on_public = true : $on_public = false;
    $data = [
        'id'   => $group['id'],
        'title'   => $group['title'],
        'tags' => $group['tags'],
        'headLimit' => $group['head_limit'],
        'onPublic'   => $on_public,
        'memo' => $group['memo'],
        'leaderId'   => $group['leader_id'],
        'joined' => $joined,
        'applied' => $applied,
        'memberCount' => $member_count,
        'createdAt' => $group['created_at']
    ];
}

echo json_encode($data);

?>