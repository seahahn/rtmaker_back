<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];

$sql = "SELECT * FROM rt_todo WHERE id='$id'";
$result = mq($sql);

while($rt = $result->fetch_assoc()) {
    $data = [
        // 'id'   => $rt['id'],
        // 'mType' => $rt['m_type'],
        'rtTitle'   => $rt['title'],
        'mDays' => $rt['m_days'],
        'alarm'   => $rt['alarm'],
        'date' => $rt['m_date'],
        'time' => $rt['m_time'],
        'onFeed'   => $rt['on_feed'],
        'memo' => $rt['memo']
        // 'userId'   => $rt['user_id'],
        // 'createdAt' => $rt['created_at']
    ];
}

echo json_encode($data);

?>