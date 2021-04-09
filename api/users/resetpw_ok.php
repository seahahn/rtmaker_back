<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$email = $_POST["email"];
$pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mq($sql);
$user = mysqli_fetch_array($result);

mq("UPDATE user SET
            pw = '$pw',
            hashv = ''
            WHERE email='$email'
            ");

$response = [
    'result'   => true,
    'msg' => "변경되었습니다."
];

echo json_encode($response);

?>