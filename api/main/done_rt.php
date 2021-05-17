<?php
/** 
 * 메인 액티비티에서 루틴 또는 할 일의 체크박스 클릭 시 작동할 기능
 * 루틴의 경우 완료 여부(체크를 했느냐 안 했느냐)에 따라 해당 루틴과 이에 속한 행동들의 완료 여부를 변경함
 * 완료했으면 다음 수행 예정일로 날짜 데이터를 변경하고,
 * 완료 상태에서 다시 체크박스를 눌러 체크를 해제(미완료)하면 당일 날짜로 다시 되돌림
 * 
 * 할 일의 경우 반복하지 않으면 완료 여부만 변경, 
 * 반복하면 완료 여부 변경과 함께 다음 수행 예정일에 같은 내용을 가진 할 일을 생성함
*/
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";
include_once "fun_done.php"; // 루틴 및 할 일 완료 처리를 위한 메소드를 모아둔 파일

$id = $_GET['id']; // 루틴(할 일) 고유 번호
$done = $_GET['done']; // 완료 구분(0이면 미완료, 1이면 완료)
$m_date = $_GET['m_date']; // 다음 수행 날짜(루틴이거나 반복하는 할 일인 경우) 또는 당일 날짜
$done_date = $_GET['done_date']; // 루틴을 수행한 날짜(당일 날짜)

// 루틴 or 할 일 수행 여부 처리하기(완료 or 미완료)
$done_update = mq("UPDATE rt_todo SET done = '$done' WHERE id='$id'");

// 완료 처리한 루틴(할 일)의 데이터 가져오기
$sql = "SELECT * FROM rt_todo WHERE id='$id'";
$result = mysqli_fetch_assoc(mq($sql));
$type = $result['m_type'];

// 루틴(할 일) 완료한 경우
if($done == 1 && $m_date != ""){
    if($type == "rt") {
        // 루틴의 다음 수행 예정일로 날짜값 바꾸기
        mq("UPDATE rt_todo SET
            m_date = '$m_date'
            WHERE id = '$id'
            ");

        // 루틴 수행 데이터(과거 내역) 추가하기
        // 루틴 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
        // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 1로 변경
        done_rt($id, $result['title'], $result['m_days'], $done_date, $result['m_time'], $result['memo'], $result['user_id'], $done);

        // 루틴에 포함된 행동 전체 완료 처리
        done_actions($id, $done_date, $done);
    } else {
        // 완료 처리한 할 일의 다음 수행 날짜 데이터가 있는지 없는지 확인하기
        // 할 일과 동일한 제목, 그리고 다음 수행 날짜를 가진 데이터가 없으면 다음에 수행할 할 일 추가함
        done_todo($result['title'], $type, $result['m_days'], $m_date, $result['m_time'], $result['alarm'], $result['on_feed'], $result['memo'], $result['user_id']);        
    }
} else if($done == 0 && $type == "rt") {
    // 오늘(루틴을 수행 가능한) 날짜로 루틴의 수행 예정일 되돌려놓기
    mq("UPDATE rt_todo SET
        m_date = '$m_date'
        WHERE id = '$id'
        ");

    // 루틴 수행 데이터(과거 내역)가 추가되어 있는지 확인 후,
    // 추가되어 있으면 이 데이터의 완료 여부(done 값)을 0으로 변경
    done_rt($id, $result['title'], $result['m_days'], $done_date, $result['m_time'], $result['memo'], $result['user_id'], $done);

    // 루틴에 포함된 행동을 미완료 상태로 바꾸기
    done_actions($id, $done_date, $done);
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