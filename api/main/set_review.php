<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$content = $_POST['content'];
$_POST['on_public'] == "true" ? $on_public = 1 : $on_public = 0;
$m_date = $_POST['m_date'];
$user_id = $_POST['user_id'];

$check = mq("SELECT * FROM review WHERE m_date = '$m_date' AND user_id = '$user_id'");
$count = mysqli_num_rows($check);

if($count == 0) {
    $mq = mq("INSERT review SET
    content = '$content',
    on_public = '$on_public',
    m_date = '$m_date',
    user_id = '$user_id'
    ");
} else {
    $mq = mq("UPDATE review SET
    content = '$content',
    on_public = '$on_public'
    WHERE m_date = '$m_date' AND user_id = '$user_id'
    ");
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