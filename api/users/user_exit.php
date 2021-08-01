<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];

$mq = mq("DELETE FROM user WHERE id='$id'");

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "회원 탈퇴 되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "탈퇴에 실패했습니다."
    ];
}

echo json_encode($response);

?>