<?php
/** 
 * 채팅방 데이터를 반환하기 위한 소스 코드
 * 사용자 고유 번호와 함께 그룹 번호 또는 대화 상대방 번호를 받으면 이에 해당하는 채팅방이 있는지 확인
 * 있으면 해당 채팅방 데이터를, 없으면 새로 만든 후 이 채팅방 데이터를 보내줌
 */
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$_POST['is_groupchat'] == "true" ? $is_groupchat = 1 : $is_groupchat = 0;
$host_id = $_POST['host_id'];
$audience_id = $_POST['audience_id'];

// $is_groupchat = 1;
// $host_id = 30;
// $audience_id = 40;

$mq = mq("SELECT * FROM chat_room 
        WHERE is_groupchat='$is_groupchat' AND host_id='$host_id' AND audience_id='$audience_id'");
$exist = mysqli_num_rows($mq);

if($exist == 0 && $is_groupchat == 0) {
    $mq = mq("SELECT * FROM chat_room 
            WHERE is_groupchat='$is_groupchat' AND host_id='$audience_id' AND audience_id='$host_id'");
    $exist = mysqli_num_rows($mq);
}

if($exist == 0) {
    $mq = mq("INSERT chat_room SET
    is_groupchat = '$is_groupchat',
    audience_id = '$audience_id',
    host_id = '$host_id',
    member_list = '$host_id'
    ");

    $mq = mq("SELECT * FROM chat_room 
            WHERE is_groupchat='$is_groupchat' AND host_id='$host_id' AND audience_id='$audience_id'");
}
// 채팅방 데이터 보내기
$result = $mq->fetch_assoc();
$data = [
        'id'   => $result['id'],
        'isGroupchat'   => $result['is_groupchat'],
        'userId' => $result['host_id'],
        'audienceId' => $result['audience_id'],
        'memberList'   => $result['member_list'],
        'createdAt' => $result['created_at']
        ];

echo json_encode($data);

?>