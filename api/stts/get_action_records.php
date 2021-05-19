<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM action_done WHERE user_id='$user_id' ORDER BY pos ASC";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($action = $result->fetch_assoc()) {
    $data = [
        'id'   => $action['action_id'],
        'actionTitle'   => $action['title'],
        'time' => $action['m_time'],
        'memo' => $action['memo'],
        'mDate' => $action['m_date'],
        'rtId' => $action['rt_id'],
        'userId'   => $action['user_id'],
        'done'   => $action['done'],
        'pos'   => $action['pos']
    ];
    array_push($array, $data);
}

echo json_encode($array);
?>