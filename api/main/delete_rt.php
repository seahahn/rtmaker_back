<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];

$mq = mq("DELETE FROM rt_todo WHERE id='$id'");

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