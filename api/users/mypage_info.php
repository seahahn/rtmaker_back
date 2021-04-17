<?php
/** 마이페이지의 사용자 정보 보내주기 위한 api
 * 사용자의 고유 번호(id) 값을 받으면 그에 해당하는 사용자 정보를 돌려줌
 */
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id='$id'";
    $result = mq($sql);
    $ret = mysqli_fetch_array($result);

    echo json_encode($ret);
?>