<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM rt_todo WHERE user_id='$user_id' ORDER BY m_date ASC, m_time ASC";
$result = mq($sql);
// $mfa = $result->fetch_array();


$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($rt = $result->fetch_assoc()) {
    $data = [
        'id'   => $rt['id'],
        'mType' => $rt['m_type'],
        'rtTitle'   => $rt['title'],
        'mDays' => $rt['m_days'],
        'alarm'   => $rt['alarm'],
        'date' => $rt['m_date'],
        'time' => $rt['m_time'],
        'onFeed'   => $rt['on_feed'],
        'memo' => $rt['memo'],
        'userId'   => $rt['user_id'],
        'done'   => $rt['done'],
        'createdAt' => $rt['created_at']
    ];

    array_push($array, $data);
}

echo json_encode($array);

?>