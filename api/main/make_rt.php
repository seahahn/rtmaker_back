<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$m_type = $_POST['m_type'];
$title = $_POST['title'];
$m_days = $_POST['m_days'];
$_POST['alarm'] == "true" ? $alarm = 1 : $alarm = 0;
$_POST['m_date'] ? $m_date = $_POST['m_date'] : $m_date = "";
$m_time = $_POST['m_time'];
$_POST['on_feed'] == "true" ? $on_feed = 1 : $on_feed = 0;
$memo = $_POST['memo'];
$user_id = $_POST['user_id'];

// $m_type = "rt";
// $title = "첫 루틴";
// $m_days = "일 월 화 수 목 금 토";
// $alarm = false;
// $m_time = "21:28";
// $on_feed = false;
// $memo = "메모 테스트";
// $user_id = 30;

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
// if(isset($_POST['m_type'])) {
if(isset($m_type)) {
    $mq = mq("INSERT rt_todo SET
    m_type = '$m_type',
    title = '$title',
    m_days = '$m_days',
    alarm = '$alarm',
    m_date = '$m_date',
    m_time = '$m_time',
    on_feed = '$on_feed',
    memo = '$memo',
    user_id = '$user_id'
    ");
} else {
    $mq = false;
}

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "저장되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "저장에 실패했습니다."
    ];
}

echo json_encode($response);

?>