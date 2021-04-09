<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$email = $_GET['email'];
$hash = $_GET['hash'];
$sql = "SELECT * FROM user WHERE email='$email'";
$result = mq($sql);
$row = mysqli_fetch_array($result);
$db_hash = $row['hashv'];

if(isset($hash) && $hash == $db_hash ) {
    $response = [
        'result'   => true,
        'msg' => "인증되었습니다."
    ];

} else {
    $response = [
        'result'   => false,
        'msg' => "잘못된 접근입니다."
    ];

}

echo json_encode($response);

?>