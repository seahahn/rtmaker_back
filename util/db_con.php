<?php
    $db_id="root"; // DB 계정명
    $db_pw="0121"; // DB 계정 비밀번호(aws)
    // $db_pw=""; // DB 계정 비밀번호(데스크탑)
    // $db_pw="teamnova123"; // DB 계정 비밀번호(랩탑)
    $db_name="rtmaker"; // 연결할 데이터베이스명
    $db_domain="127.0.0.1"; // 연결할 도메인
    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    // SQL 쿼리문 간단하게 쓰기 위한 함수 mq 선언
    function mq($sql){
        global $db;
        return $db->query($sql);
    }
// 이 php 파일 만든 후에 sql 연결 필요하면 include하여 mq("실행할_쿼리문"); 이렇게 사용하면 됩니다.
?>