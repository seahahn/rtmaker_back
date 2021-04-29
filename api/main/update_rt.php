<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];
$title = $_POST['title'];
$m_days = $_POST['m_days'];
$_POST['alarm'] == "true" ? $alarm = 1 : $alarm = 0;
$_POST['m_date'] ? $m_date = $_POST['m_date'] : $m_date = "";
$m_time = $_POST['m_time'];
$_POST['on_feed'] == "true" ? $on_feed = 1 : $on_feed = 0;
$memo = $_POST['memo'];
// $user_id = $_POST['user_id'];

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
// if(isset($_POST['m_type'])) {
if(isset($id)) {
    $mq = mq("UPDATE rt_todo SET
    title = '$title',
    m_days = '$m_days',
    alarm = '$alarm',
    m_date = '$m_date',
    m_time = '$m_time',
    on_feed = '$on_feed',
    memo = '$memo'
    WHERE id = '$id'
    ");
} else {
    $mq = false;
}

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "수정되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "수정에 실패했습니다."
    ];
}

echo json_encode($response);

?>