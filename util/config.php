<!-- 세션 관리 -->
<?php
    session_start();
    if (isset($_SESSION["useremail"])) {
        $useremail = $_SESSION["useremail"];
    }else{
        $useremail = "";
    }
    
    if (isset($_SESSION["usernick"])){
        $usernick = $_SESSION["usernick"];
    }else{
        $usernick = "";
    }
    
    if (isset($_SESSION["role"])){ // 사용자, 관리자 구분 용도
        $role = $_SESSION["role"];
    }else{
        $role = "";
    }
    
    if (isset($_SESSION["idx"])){ // DB상의 사용자 고유 번호
        $usernum = $_SESSION["idx"];
    }else{
        $usernum = "";
    }
?>