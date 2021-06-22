<?php
/** 
 * 채팅방 데이터를 반환하기 위한 소스 코드
 * 사용자 고유 번호와 함께 그룹 번호 또는 대화 상대방 번호를 받으면 이에 해당하는 채팅방이 있는지 확인
 * 있으면 해당 채팅방 데이터를, 없으면 새로 만든 후 이 채팅방 데이터를 보내줌
 */
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id'];

$mq = mq("SELECT * FROM chat_room WHERE id='$id'");

// 채팅방 데이터 보내기
$result = $mq->fetch_assoc();
$result['is_groupchat'] == 1 ? $is_groupchat = true : $is_groupchat = false;
$data = [
        'id'   => $result['id'],
        'isGroupchat'   => $is_groupchat,
        'hostId' => $result['host_id'],
        'audienceId' => $result['audience_id'],
        'memberList'   => $result['member_list'],
        'createdAt' => $result['created_at']
        ];

echo json_encode($data);

?>