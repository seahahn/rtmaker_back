<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];

$sql = "SELECT * FROM action WHERE id='$id'";
$result = mq($sql);

while($action = $result->fetch_assoc()) {
    $data = [
        'title'   => $action['title'],
        'time' => $action['m_time'],
        'memo' => $action['memo'],
        'rtId' => $action['rt_id']
    ];
}

echo json_encode($data);

?>