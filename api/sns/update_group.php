<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];
$title = $_POST['title'];
$tags = $_POST['tags'];
$head_limit = $_POST['head_limit'];
$_POST['is_locked'] == "true" ? $is_locked = 1 : $is_locked = 0;
$memo = $_POST['memo'];

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
if(isset($id)) {
    $mq = mq("UPDATE sns_group SET
    title = '$title',
    tags = '$tags',
    head_limit = '$head_limit',
    is_locked = '$is_locked',
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