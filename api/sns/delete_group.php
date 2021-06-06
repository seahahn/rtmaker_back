<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST['id'];

$mq = mq("DELETE FROM sns_group WHERE id='$id'");
mq("DELETE FROM sns_group_users WHERE group_id='$id'");

$response;

if($mq) {
    $response = [
        'result'   => true,
        'msg' => "그룹이 해체되었습니다."
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "해체에 실패했습니다."
    ];
}

echo json_encode($response);

?>