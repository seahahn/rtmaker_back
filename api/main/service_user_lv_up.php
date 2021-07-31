<?php
/** 
 * 0시 기준으로 어제 자신의 모든 루틴을 수행한 유저에 대하여 유저의 레벨을 1 상승시킴
*/
include_once "/htdocs/util/db_con.php";

$timezone = 'Asia/Seoul'; // 시간대를 서울로 설정
date_default_timezone_set($timezone);

$yesterday = date("Y-m-d", strtotime("-1 day")); // 어제 날짜 구하기

$sql = "SELECT id, lv FROM user WHERE active = 1"; // 전체 유저 목록을 가져옴(고유 번호와 레벨만)
$result = mq($sql);

// 불러온 유저 데이터 각각에 대하여 레벨업 조건 충족 여부를 확인 후 이에 맞춰 레벨업을 시키거나 그대로 둠
while($user = $result->fetch_assoc()) {
    // 해당 유저의 어제 루틴 수행 내역 갯수 가져오기
    $all_record = mq("SELECT * FROM rt_done WHERE m_date = '$yesterday' AND user_id = '$user[id]'");
    $all_count = mysqli_num_rows($all_record);
    
    // 해당 유저의 어제 루틴 수행 내역 중 완료한 것의 갯수 가져오기
    $done_record = mq("SELECT * FROM rt_done WHERE m_date = '$yesterday' AND user_id = '$user[id]' AND done = 1");
    $done_count = mysqli_num_rows($done_record);
    
    $lv_up = $user['lv']+1; // 이전 레벨에서 1 상승시키기

    // 루틴을 수행한 내역이 있고, 전체 수행 내역과 완료 내역의 갯수가 같으면 해당 유저의 레벨을 상승시킴
    if($all_count != 0 && $all_count == $done_count) mq("UPDATE user SET lv = $lv_up WHERE id = '$user[id]'");

}
?>