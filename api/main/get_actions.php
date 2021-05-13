<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$rt_id = $_GET['rt_id'];
$user_id = $_GET['user_id'];
$_GET['past'] == "true" ? $past = 1 : $past = 0; // 사용자가 선택한 날짜가 과거인지 아닌지의 여부를 받음
$done_day = $_GET['done_day'];

if(!$past) {
    // 과거가 아닌 경우
    $sql = "SELECT * FROM action WHERE rt_id='$rt_id' AND user_id='$user_id' ORDER BY pos ASC";
    $result = mq($sql);

    $array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
    while($action = $result->fetch_assoc()) {
        $data = [
            'id'   => $action['id'],
            'actionTitle'   => $action['title'],
            'time' => $action['m_time'],
            'memo' => $action['memo'],
            'm_date' => $action['m_date'],
            'rtId' => $action['rt_id'],
            'userId'   => $action['user_id'],
            'done'   => $action['done'],
            'pos'   => $action['pos'],
            'createdAt' => $action['created_at']
        ];

        array_push($array, $data);
    }
} else {
    // 과거인 경우
    $sql = "SELECT * FROM action_done WHERE rt_id='$rt_id' AND user_id='$user_id' 
            AND m_date='$done_day' ORDER BY pos ASC";
    $result = mq($sql);

    $array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
    while($action = $result->fetch_assoc()) {
        $data = [
            'id'   => $action['action_id'],
            'actionTitle'   => $action['title'],
            'time' => $action['m_time'],
            'memo' => $action['memo'],
            'm_date' => $action['m_date'],
            'rtId' => $action['rt_id'],
            'userId'   => $action['user_id'],
            'done'   => $action['done'],
            'pos'   => $action['pos']
        ];

        array_push($array, $data);
    }
}



echo json_encode($array);

?>