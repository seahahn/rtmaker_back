<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id_moved = $_POST['id_moved'];
$id_pushed = $_POST['id_pushed'];
$pos_moved = $_POST['pos_moved'];
$pos_pushed = $_POST['pos_pushed'];

// 들어온 값 있을 경우 DB에 사용자 가입 정보 저장
if(isset($id_moved) && isset($id_pushed)) {
    $mq = mq("UPDATE action SET
    pos = '$pos_moved'
    WHERE id = '$id_moved'
    ");

    $mq = mq("UPDATE action SET
    pos = '$pos_pushed'
    WHERE id = '$id_pushed'
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