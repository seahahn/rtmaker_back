<?php
/** 
 * 0시 기준으로 당일에 수행 예정인 루틴 및 루틴 내 행동에 대한 수행(done) 데이터를 생성
 * 이는 사용자의 폰이 장기간 꺼져 있는 경우에도 루틴 수행에 대한 과거 내역을 생성 및 누적하기 위함임
*/
include_once "../../util/db_con.php";
include_once "fun_done.php"; // 루틴 및 할 일 완료 처리를 위한 메소드를 모아둔 파일

// 오늘 날짜를 통해 오늘의 요일 구하기
// 이 요일 문자열을 가진 모든 루틴을 찾아오기 위함
$timezone = 'Asia/Seoul'; // 시간대를 서울로 설정
date_default_timezone_set($timezone);
$today = date("Y-m-d", time()); // 오늘 날짜 구하기
$week_string = array("일", "월", "화", "수", "목", "금", "토");
$dayoftoday = $week_string[date('w', strtotime($today))]; // 오늘 요일 구하기

$sql = "SELECT * FROM rt_todo WHERE m_days LIKE '%$dayoftoday%'"; // 0시 기준 당일의 요일 이름 문자열을 m_days에 포함한 루틴 데이터 불러오기
$result = mq($sql);

// 불러온 루틴 데이터 각각에 대하여 수행 데이터를 생성함
while($rt = $result->fetch_assoc()) {
    mq("UPDATE rt_todo SET m_date = '$today' WHERE id = '$rt[id]'");
    done_rt($rt['id'], $rt['title'], $rt['m_days'], $today, $rt['m_time'], $rt['alarm'], $rt['on_feed'], $rt['memo'], $rt['user_id'], 0);
    done_actions($rt['id'], $today, 0);
}
?>