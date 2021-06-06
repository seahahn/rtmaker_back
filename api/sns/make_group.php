<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$title = $_POST['title'];
$tags = $_POST['tags'];
$head_limit = $_POST['head_limit'];
$_POST['on_public'] == "true" ? $on_public = 1 : $on_public = 0;
$memo = $_POST['memo'];
$leader_id = $_POST['leader_id'];

// 들어온 값 있을 경우 DB에 그룹 정보 저장
if(isset($title)) {
    // 그룹 정보 저장
    $mq = mq("INSERT sns_group SET
    title = '$title',
    tags = '$tags',
    head_limit = '$head_limit',
    on_public = '$on_public',
    memo = '$memo',
    leader_id = '$leader_id'
    ");

    // 그룹 가입한 사용자 목록 테이블에 그룹을 생성한 사용자 데이터 추가
    $result = mysqli_fetch_assoc(mq("SELECT * FROM sns_group WHERE title = '$title' AND leader_id = '$leader_id'"));
    $group_id = $result['id']; // 생성한 그룹의 고유 번호
    mq("INSERT sns_group_users SET
    group_id = '$group_id',
    user_id = '$leader_id'
    ");
} else {
    $mq = false;
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