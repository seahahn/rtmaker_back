<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$user_id = $_GET['user_id'];
$_GET['past'] == "true" ? $past = 1 : $past = 0; // 사용자가 선택한 날짜가 과거인지 아닌지의 여부를 받음

if(!$past) {
    // 과거가 아닌 경우
    $sql = "SELECT * FROM rt_todo WHERE user_id='$user_id' ORDER BY m_date ASC, m_time ASC";
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
            'done'   => $rt['done'],
            'createdAt' => $rt['created_at']
        ];
        array_push($array, $data);
    }
} else {
    // 과거인 경우

    // 루틴 수행 데이터(과거 내역)과 함께 할 일 데이터를 가져옴
    $sql = "SELECT rt_id AS id, m_type, title, m_days, m_date, m_time, alarm, on_feed, memo, user_id, done
            FROM rt_done WHERE user_id='$user_id' AND m_type = 'rt'
            UNION
            SELECT id, m_type, title, m_days, m_date, m_time, alarm, on_feed, memo, user_id, done
            FROM rt_todo WHERE user_id='$user_id' AND m_type = 'todo'
            ";
            // ORDER BY m_date ASC, m_time ASC
            // 
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
}

echo json_encode($array);

?>