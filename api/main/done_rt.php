<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

$id = $_GET['id']; // 루틴(할 일) 고유 번호
$done = $_GET['done']; // 완료 구분(0이면 미완료, 1이면 완료)
$m_date = $_GET['m_date']; // 다음 수행 날짜(루틴이거나 반복하는 할 일인 경우)

// 루틴(할 일) 처리하기(완료 or 미완료)
$done_update = mq("UPDATE rt_todo SET done = '$done' WHERE id='$id'");

// 루틴(할 일) 완료한 경우
if($done == 1){
    // 완료 처리한 루틴(할 일)의 데이터 가져오기
    $sql = "SELECT * FROM rt_todo WHERE id='$id'";
    $result = mysqli_fetch_assoc(mq($sql));

    $type = $result['m_type'];
    if($type == "rt") {
        mq("UPDATE rt_todo SET
        m_date = '$m_date'
        WHERE id = '$id'
        ");
    } else {
        // 완료 처리한 할 일의 다음 수행 날짜 데이터가 있는지 없는지 확인하기
        $check = mq("SELECT * FROM rt_todo WHERE title = '$result[title]' AND m_date = '$m_date'");
        $count = mysqli_num_rows($check);

        // 할 일과 동일한 제목, 그리고 다음 수행 날짜를 가진 데이터가 없으면 다음에 수행할 할 일 추가함
        if($count == 0) mq("INSERT rt_todo SET
        m_type = '$result[m_type]',
        title = '$result[title]',
        m_days = '$result[m_days]',
        alarm = '$result[alarm]',
        m_date = '$m_date',
        m_time = '$result[m_time]',
        on_feed = '$result[on_feed]',
        memo = '$result[memo]',
        user_id = '$result[user_id]'
        ");
    }
}

$response;
if($done_update) {
    $response = [
        'result'   => true,
        'msg' => "요청 수행 완료"
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "요청 처리 실패"
    ];
}

echo json_encode($response);

?>