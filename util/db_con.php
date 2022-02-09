<?php
    $db_id=$_SERVER['DB_USERID']; // DB 계정명
    $db_pw=$_SERVER['DB_PW']; // DB 계정 비밀번호(aws)
    $db_name=$_SERVER['DB_NAME']; // 연결할 데이터베이스명
    $db_domain=$_SERVER['DB_HOST']; // 연결할 도메인
    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    // SQL 쿼리문 간단하게 쓰기 위한 함수 mq 선언
    function mq($sql){
        global $db;
        return $db->query($sql);
    }
// 이 php 파일 만든 후에 sql 연결 필요하면 include하여 mq("실행할_쿼리문"); 이렇게 사용하면 됩니다.
?>
