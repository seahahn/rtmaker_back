<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST["id"];
$token = $_POST['token'];

// 사용자의 토큰값 갱신하기(재설치 등의 이유로 변동되었을 경우 대비)
mq("UPDATE user SET
            token = '$token'
            WHERE id = '$id'
            ");

mq("UPDATE chat_user SET
            token = '$token'
            WHERE user_id = '$id'");

$response = [
    'result'   => true,
    'msg' => "변경되었습니다."
];

echo json_encode($response);

?>