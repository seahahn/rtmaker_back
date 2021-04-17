<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_POST["id"];
$subject = $_POST["subject"];
$content = $_POST["content"];

// $sql = "SELECT * FROM user WHERE id='$id'";
// $result = mq($sql);
// $user = mysqli_fetch_array($result);

$change = mq("UPDATE user SET
            $subject = '$content'
            WHERE id = '$id'
            ");

if($change) {
    $response = [
        'result'   => true,
        'msg' => "정보 수정되었습니다."
        ];
    if($subject == "photo") $response['photo'] = $content;
} else {
    $response = [
        'result'   => false,
        'msg' => "정보 수정 실패"
        ];
}

echo json_encode($response);

?>