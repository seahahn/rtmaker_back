<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$group_id = $_GET['group_id'];
$_GET['joined'] == "true" ? $joined = 1 : $joined = 0;

$sql = "SELECT user_id FROM sns_group_users WHERE group_id='$group_id' AND joined='$joined' ORDER BY created_at ASC";
$result = mq($sql);

$array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
while($members = $result->fetch_assoc()) {
    // 그룹 멤버 정보 가져오기
    $userinfo = mysqli_fetch_assoc(mq("SELECT nick, photo FROM user WHERE id = '$members[user_id]'"));
    
    // 그룹 멤버 데이터 보내기
    $data = [
        'id'   => $members['user_id'],
        'nick'   => $userinfo['nick'],
        'photo'   => $userinfo['photo']
    ];
    array_push($array, $data);
}

echo json_encode($array);

?>