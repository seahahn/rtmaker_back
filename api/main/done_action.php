<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";
include_once "fun.php";

$id = $_GET['id']; // 행동 고유 번호
// $rt_id = $_GET['rt_id']; // 행동 고유 번호
$done = $_GET['done']; // 완료 구분(0이면 미완료, 1이면 완료)
$m_date = $_GET['m_date']; // 행동 수행한 날짜

// 행동 처리하기(완료 or 미완료)
$done_update = mq("UPDATE action SET done = '$done' WHERE id='$id'");

// 완료 처리한 행동의 데이터를 가져옴
$sql = "SELECT * FROM action WHERE id='$id'";
$result = mysqli_fetch_assoc(mq($sql));
$rt_id = $result['rt_id']; // 완료 처리한 행동이 속한 루틴의 고유 번호값 가져오기

// 행동 수행 데이터(과거 내역) 추가하기
if($done == 1) {
    // 행동 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 1로 변경
    // $check = mq("SELECT * FROM action_done WHERE action_id = '$result[id]' AND m_date = '$m_date'");
    // $count = mysqli_num_rows($check);
    // if($count == 0) {
    //     mq("INSERT action_done SET
    //     title = '$result[title]',
    //     m_time = '$result[m_time]',
    //     m_date = '$m_date',
    //     memo = '$result[memo]',
    //     rt_id = '$rt_id',
    //     action_id = '$result[id]',
    //     user_id = '$result[user_id]',
    //     done = '$done',
    //     pos = '$result[pos]'
    //     ");
    // } else {
    //     mq("UPDATE action_done SET
    //     done = '$done'
    //     WHERE action_id = '$result[id]' AND m_date = '$m_date'
    //     ");
    // }

    done_action($result['id'], $m_date, $result['title'], $result['m_time'], $result['memo'], 
    $rt_id, $result['user_id'], $done, $result['pos']);
} else if($done == 0) {
    // 행동 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 0으로 변경
    // $check = mq("SELECT * FROM action_done WHERE action_id = '$result[id]' AND m_date = '$m_date'");
    // $count = mysqli_num_rows($check);
    // if($count == 0) {
    //     mq("INSERT action_done SET
    //     title = '$result[title]',
    //     m_time = '$result[m_time]',
    //     m_date = '$m_date',
    //     memo = '$result[memo]',
    //     rt_id = '$rt_id',
    //     action_id = '$result[id]',
    //     user_id = '$result[user_id]',
    //     done = '$done',
    //     pos = '$result[pos]'
    //     ");
    // } else {
    //     mq("UPDATE action_done SET
    //     done = '$done'
    //     WHERE action_id = '$result[id]' AND m_date = '$m_date'
    //     ");
    // }

    done_action($result['id'], $m_date, $result['title'], $result['m_time'], $result['memo'], 
    $rt_id, $result['user_id'], $done, $result['pos']);
}

// 완료 처리한 행동이 속한 루틴의 번호 값을 이용하여 이에 속한 행동 전체의 완료 여부를 체크함
$sql = "SELECT * FROM action WHERE rt_id='$rt_id'";
$sql_done = "SELECT * FROM action WHERE rt_id='$rt_id' AND done=1";
$result_num = mysqli_num_rows(mq($sql)); // 전체 행동 개수
$result_done = mysqli_num_rows(mq($sql_done)); // 완료한 행동 개수
$all_done = $result_num == $result_done; // 전체 완료 여부

$sql_rt = "SELECT * FROM rt_todo WHERE id='$rt_id'";
$result = mysqli_fetch_assoc(mq($sql_rt));

// 루틴 내 행동 모두 완료 시 행동이 속한 루틴 완료 처리하기
if($all_done){
    $test = "트루";
    mq("UPDATE rt_todo SET
    m_date = '$m_date',
    done = '$all_done'
    WHERE id = '$rt_id'
    ");

    // 루틴 수행 데이터(과거 내역) 추가하기
    // 루틴 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 1로 변경
    $check = mq("SELECT * FROM rt_done WHERE rt_id = '$rt_id' AND m_date = '$m_date'");
    $count = mysqli_num_rows($check);
    if($count == 0) {
        mq("INSERT rt_done SET
        title = '$result[title]',
        m_days = '$result[m_days]',
        m_date = '$m_date',
        m_time = '$result[m_time]',
        rt_id = '$rt_id',
        user_id = '$result[user_id]',
        done = '$done'
        ");
    } else {
        mq("UPDATE rt_done SET
        done = '$done'
        WHERE rt_id = '$rt_id' AND m_date = '$m_date'
        ");
    }
} else {
    $test = "낫트루";
    mq("UPDATE rt_todo SET
    m_date = '$m_date',
    done = '$all_done'
    WHERE id = '$rt_id'
    ");

    // 루틴 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 0으로 변경
    $check = mq("SELECT * FROM rt_done WHERE rt_id = '$rt_id' AND m_date = '$m_date'");
    $count = mysqli_num_rows($check);
    if($count != 0) mq("UPDATE rt_done SET
    done = '$done'
    WHERE rt_id = '$rt_id' AND m_date = '$m_date'
    ");
}

$response;
if($done_update) {
    $response = [
        'result'   => true,
        'msg' => "요청 수행 완료",
        'test' => $test,
        'all_done' => $all_done,
        'rtId' => $rt_id
    ];
} else {
    $response = [
        'result'   => false,
        'msg' => "요청 처리 실패",
        'test' => $test,
        'all_done' => $all_done,
        'rtId' => $rt_id
    ];
}

echo json_encode($response);

?>