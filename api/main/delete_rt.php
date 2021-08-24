<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];

$mq = mq("DELETE FROM rt_todo WHERE id='$id'");

$today = date("Y-m-d", time()); // 오늘 날짜 구하기
mq("DELETE FROM rt_done WHERE rt_id='$id' AND m_date='$today'"); // 오늘 날짜에 루틴의 수행 데이터 남아있는 경우 삭제시키기
mq("DELETE FROM action_done WHERE rt_id='$id' AND m_date='$today'"); // 오늘 날짜에 행동의 수행 데이터 남아있는 경우 삭제시키기

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "삭제되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "삭제에 실패했습니다."
    ];
}

echo json_encode($response);

?>