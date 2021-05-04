<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$title = $_POST['title'];
$m_time = $_POST['m_time'];
$memo = $_POST['memo'];
$rt_id = $_POST['rt_id'];
$user_id = $_POST['user_id'];

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
if(isset($title)) {
    $test = "dd";
    $mq = mq("INSERT action SET
    title = '$title',
    m_time = '$m_time',
    memo = '$memo',
    rt_id = '$rt_id',
    user_id = '$user_id'
    ");
} else {
    $test = "xx";
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