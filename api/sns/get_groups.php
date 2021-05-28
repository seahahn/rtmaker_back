<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];

if(isset($user_id)) {
    $sql = "SELECT * FROM sns_group WHERE user_id='$user_id' ORDER BY title ASC";
} else {
    $sql = "SELECT * FROM sns_group ORDER BY title ASC";
}
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
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
    array_push($array, $data);
}

echo json_encode($array);

?>