<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST["id"];
$token = $_POST['token'];

mq("UPDATE user SET
            token = '$token'
            WHERE id='$id'
            ");

$response = [
    'result'   => true,
    'msg' => "변경되었습니다."
];

echo json_encode($response);

?>