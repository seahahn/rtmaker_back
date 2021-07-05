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

// 그룹 채팅 여부와 채팅방 방장 고유 번호 및 채팅 상대방 고유 번호(그룹채팅이면 그룹, 1:1이면 상대방)를 이용하여 채팅방 존재 여부 확인
$mq = mq("SELECT * FROM chat_room 
        WHERE is_groupchat='$is_groupchat' AND host_id='$host_id' AND audience_id='$audience_id'");
$exist = mysqli_num_rows($mq);

// 1:1 채팅인데 채팅방이 조회되지 않는 경우 채팅을 건 사람과 받은 사람을 바꾸어서 재조회
if($exist == 0 && $is_groupchat == 0) {
    $mq = mq("SELECT * FROM chat_room 
            WHERE is_groupchat='$is_groupchat' AND host_id='$audience_id' AND audience_id='$host_id'");
    $exist = mysqli_num_rows($mq);
}

// 채팅방이 없으면 채팅방 데이터를 생성한 후에 이 데이터를 그대로 가져옴
if($exist == 0) {
    $mq = mq("INSERT chat_room SET
    is_groupchat = '$is_groupchat',
    audience_id = '$audience_id',
    host_id = '$host_id'
    ");

    $mq = mq("SELECT * FROM chat_room 
            WHERE is_groupchat='$is_groupchat' AND host_id='$host_id' AND audience_id='$audience_id'");
}
// 채팅방 데이터 보내기
$result = $mq->fetch_assoc();
$result['is_groupchat'] == 1 ? $is_groupchat = true : $is_groupchat = false;
$data = [
        'id'   => $result['id'],
        'isGroupchat'   => $is_groupchat,
        'hostId' => $result['host_id'],
        'audienceId' => $result['audience_id'],
        'createdAt' => $result['created_at']
        ];

echo json_encode($data);

?>