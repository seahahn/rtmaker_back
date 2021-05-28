<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];

$sql = "SELECT * FROM sns_group WHERE id='$id'";
$result = mq($sql);

while($group = $result->fetch_assoc()) {
    $data = [
        'id'   => $group['id'],
        'title'   => $group['title'],
        'tags' => $group['tags'],
        'headLimit' => $group['head_limit'],
        'members' => $group['members'],
        'isLocked'   => $group['is_locked'],
        'memo' => $group['memo'],
        'userId'   => $group['user_id'],
        'createdAt' => $group['created_at']
    ];
}

echo json_encode($data);

?>