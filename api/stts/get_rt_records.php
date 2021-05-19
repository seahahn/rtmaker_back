<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];

$sql = "SELECT rt_id AS id, m_type, title, m_days, m_date, m_time, alarm, on_feed, memo, user_id, done
FROM rt_done WHERE user_id='$user_id'
ORDER BY m_date ASC, m_time ASC
";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($rt = $result->fetch_assoc()) {
    $data = [
        'id'   => $rt['id'],
        'mType' => $rt['m_type'],
        'rtTitle'   => $rt['title'],
        'mDays' => $rt['m_days'],
        'mDate' => $rt['m_date'],
        'mTime' => $rt['m_time'],
        'alarm'   => $rt['alarm'],
        'onFeed'   => $rt['on_feed'],
        'memo' => $rt['memo'],
        'userId'   => $rt['user_id'],
        'done'   => $rt['done']
    ];
    array_push($array, $data);
}

echo json_encode($array);
?>