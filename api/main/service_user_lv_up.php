<?php
/** 
 * 0시 기준으로 어제 자신의 모든 루틴을 수행한 유저에 대하여 유저의 레벨을 1 상승시킴
*/
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";
// include_once "/htdocs/util/db_con.php";
// include_once "fun_done.php"; // 루틴 및 할 일 완료 처리를 위한 메소드를 모아둔 파일

// 오늘 날짜를 통해 오늘의 요일 구하기
// 이 요일 문자열을 가진 모든 루틴을 찾아오기 위함
$timezone = 'Asia/Seoul'; // 시간대를 서울로 설정
date_default_timezone_set($timezone);
// $week_string = array("일", "월", "화", "수", "목", "금", "토");

$today = date("Y-m-d", time()); // 오늘 날짜 구하기
$yesterday = date("Y-m-d", strtotime("-1 day")); // 어제 날짜 구하기
// $dayoftoday = $week_string[date('w', strtotime($today))]; // 오늘 요일 구하기
// $dayofyesterday = $week_string[date('w', strtotime($yesterday))]; // 어제 요일 구하기

$sql = "SELECT id, lv FROM user WHERE active = 1"; // 전체 유저 목록을 가져옴(고유 번호와 레벨만)
$result = mq($sql);

// 불러온 루틴 데이터 각각에 대하여 수행 데이터를 생성함
while($user = $result->fetch_assoc()) {
    $all_record = mq("SELECT * FROM rt_done WHERE m_date = '$yesterday' AND user_id = '$user[id]'");
    $all_count = mysqli_num_rows($all_record);
    
    $done_record = mq("SELECT * FROM rt_done WHERE m_date = '$yesterday' AND user_id = '$user[id]' AND done = 1");
    $done_count = mysqli_num_rows($done_record);
    
    $lv_up = $user['lv']+1;
    if($all_count == $done_count) mq("UPDATE user SET lv = $lv_up WHERE id = '$user[id]'");

}
?>