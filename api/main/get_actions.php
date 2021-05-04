<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$rt_id = $_GET['rt_id'];
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM action WHERE rt_id='$rt_id' AND user_id='$user_id' ORDER BY created_at ASC";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($action = $result->fetch_assoc()) {
    $data = [
        'id'   => $action['id'],
        'actionTitle'   => $action['title'],
        'time' => $action['m_time'],
        'memo' => $action['memo'],
        'color' => $action['color'],
        'rtId' => $action['rt_id'],
        'userId'   => $action['user_id'],
        'done'   => $action['done'],
        'createdAt' => $action['created_at']
    ];

    array_push($array, $data);
}

echo json_encode($array);

?>