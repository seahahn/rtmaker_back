<?php
/** 
 * 0시 기준으로 당일에 수행 예정인 루틴 및 루틴 내 행동에 대한 수행(done) 데이터를 생성
 * 이는 사용자의 폰이 장기간 꺼져 있는 경우에도 루틴 수행에 대한 과거 내역을 생성 및 누적하기 위함임
*/
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";
include_once "fun_done.php"; // 루틴 및 할 일 완료 처리를 위한 메소드를 모아둔 파일

// 오늘 날짜를 통해 오늘의 요일 구하기
// 이 요일 문자열을 가진 모든 루틴을 찾아오기 위함
$today = date("Y-m-d", time()); // 오늘 날짜 구하기
$week_string = array("일", "월", "화", "수", "목", "금", "토");
$dayoftoday = $week_string[date('w', strtotime($today))]; // 오늘 요일 구하기

$sql = "SELECT * FROM rt_todo WHERE m_days LIKE '%$dayoftoday%'"; // 0시 기준 당일의 요일 이름 문자열을 m_days에 포함한 루틴 데이터 불러오기
$result = mq($sql);

// $array = array(); // 앱에 전달할 JSON 데이터를 담을 array.
// while($rt = $result->fetch_assoc()) {
//     $data = [
//         'id'   => $rt['id'],
//         'mType' => $rt['m_type'],
//         'rtTitle'   => $rt['title'],
//         'mDays' => $rt['m_days'],
//         'mDate' => $rt['m_date'],
//         'mTime' => $rt['m_time'],
//         'alarm'   => $rt['alarm'],
//         'onFeed'   => $rt['on_feed'],
//         'memo' => $rt['memo'],
//         'userId'   => $rt['user_id'],
//         'done'   => $rt['done'],
//         'createdAt' => $rt['created_at']
//     ];
//     array_push($array, $data);
// }
// echo json_encode($array);

// 완료 처리한 루틴(할 일)의 데이터 가져오기
// $sql = "SELECT * FROM rt_todo WHERE id='$id'";
// $result = mysqli_fetch_assoc(mq($sql));

done_rt($id, $result['title'], $result['m_days'], $result['m_date'], $result['m_time'], $result['memo'], $result['user_id'], 0);
done_actions($id, $result['m_date'], 0);

?>