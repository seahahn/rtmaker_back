<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$m_date = $_GET['m_date'];
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM review WHERE m_date='$m_date' AND user_id='$user_id'";
$result = mq($sql);

while($review = $result->fetch_assoc()) {
    $review['on_public'] == 1 ? $on_public = true : $on_public = false;
    $data = [
        'content'   => $review['content'],
        'on_public' => $on_public
    ];
}

echo json_encode($data);

?>