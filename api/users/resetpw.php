<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db_con.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require $_SERVER["DOCUMENT_ROOT"]."/vendor/PHPMailer/PHPMailer/src/PHPMailer.php";
// require $_SERVER["DOCUMENT_ROOT"]."/vendor/PHPMailer/PHPMailer/src/SMTP.php";
// require $_SERVER["DOCUMENT_ROOT"]."/vendor/PHPMailer/PHPMailer/src/Exception.php";
require $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';

// $email = $_POST['email'];
$hash = rand(1000,9999); // 이메일 인증 위한 해쉬값(4자리 숫자) 생성

!empty($_GET['email']) ? $email = $_GET['email'] : $email = "";
$regEmail = '/^[a-zA-Z]{1}[a-zA-Z0-9.\-_]+@[a-z0-9]{1}[a-z0-9\-]+[a-z0-9]{1}\.(([a-z]{1}[a-z.]+[a-z]{1})|([a-z]+))$/';

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mq($sql);
$num = mysqli_num_rows($result);
$user = mysqli_fetch_array($result);
$nick = $user['nick'];
$inway = $user['inway'];

if($email != ""){

    if(!preg_match($regEmail, $email)) {
        $ret['msg'] = "올바르지 않은 이메일입니다.";
        $ret['result'] = false;

        echo json_encode($ret);
        return;
    }
    else if($num==0){
        $ret['msg'] = "가입되지 않은 이메일입니다.";
        $ret['result'] = false;

        echo json_encode($ret);
        return;
    }
    else if($inway != 'etc'){
        $ret['msg'] = "SNS로 가입된 이메일입니다.\n 이용중인 SNS로 로그인해주세요.";
        $ret['result'] = false;

        echo json_encode($ret);
        return;
    }
} else {
    $ret['msg'] = "이메일을 입력해주세요.";
    $ret['result'] = false;

    echo json_encode($ret);
    return;
}

$mail = new PHPMailer(true);

try {
    // 메일 서버세팅
    $mail -> SMTPDebug = false;    // 디버깅 설정
    $mail -> isSMTP();        // SMTP 사용 설정

    $mail -> Host = "smtp.gmail.com";                // email 보낼때 사용할 서버를 지정
    $mail -> SMTPAuth = true;                        // SMTP 인증을 사용함
    $mail -> Username = "rtmaker.noreply@gmail.com";    // 메일 계정
    $mail -> Password = $_SERVER['SMTP_PW'];                // 메일 비밀번호
    $mail -> SMTPSecure = "ssl";                    // SSL을 사용함
    $mail -> Port = 465;                            // email 보낼때 사용할 포트를 지정
    $mail -> CharSet = "utf-8";                        // 문자셋 인코딩
    $mail -> Encoding = "base64";

    // 보내는 메일
    $mail -> setFrom("rtmaker.noreply@gmail.com", "no-reply");

    // 받는 메일    
    $mail -> addAddress("$email", "$nick");

    // 메일 내용
    $mail -> isHTML(true);                                               // HTML 태그 사용 여부
    $mail -> Subject = '[루틴메이커] '.$nick.' 님, 비밀번호 재설정을 위한 인증번호입니다.';              // 메일 제목
    $mail -> Body = '
    <table class="wrapper" style="border-collapse: collapse;table-layout: fixed;min-width: 320px;width: 100%;background-color: #f8f8f9;" cellpadding="0" cellspacing="0"><tbody><tr><td>

    <div>
    <div style="margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 167440px);">
        <div style="border-collapse: collapse;display: table;width: 100%;">
        <div style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #b8b8b8;font-family:sans-serif;"></div>
        <div style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #b8b8b8;font-family:sans-serif;"></div>
        </div>
    </div>
    </div>

    <div>
    <div style="margin:0 auto;max-width:600px;min-width:320px;width:320px;width:calc(28000% - 167400px);word-wrap:break-word;word-break:break-word">
        <div style="border-collapse:collapse;display:table;width:100%;background-color:#ffffff">
        <div style="text-align:left;color:#60666d;font-size:14px;line-height:21px;font-family:sans-serif;max-width:600px;min-width:320px;width:320px;width:calc(28000% - 167400px)">

            <div align="left" style="font-size:12px;font-style:normal;font-weight:normal;line-height:19px;margin-left:20px;margin-right:20px;margin-top:40px">
            <img style="border:0;display:block;height:auto;width:100%;max-width:150px" alt="" width="150" src="https://tentuad.s3.ap-northeast-2.amazonaws.com/webimg/logo_dark.png" tabindex="0">
            <div dir="ltr" style="opacity: 0.01; left: 1063px; top: 406px;">
                <div tabindex="0">
                <div></div>
                </div>
            </div>
            <div dir="ltr" style="opacity: 0.01;"></div>
            </div>

            <!-- 제목 -->
            <div align="center" style="font-size:12px;font-style:normal;font-weight:normal;line-height:19px;margin-left:20px;margin-right:20px;margin-top:15px">
            <div style="line-height:1px;font-size:1px;background-color: #0b1121;">&nbsp;</div>
            <div style="margin-top: 50px; margin-bottom: 0; text-align:center;font-family:sans-serif;line-height:1;font-size: 36px;font-style: normal;font-stretch: normal;letter-spacing: -1.2px;color:#333333">
                <strong style="line-height:1">비밀번호 재설정을 위한<br>이메일 인증 번호</strong>
            </div>
            </div>

            <!-- 내용 -->
            <div style="margin-left:20px;margin-right:20px">
            <div>
                <p align="center" style="margin-top:32px;margin-bottom:16px;font-family:sans-serif;color:#0b1121;font-size: 14px;font-style: normal;font-stretch: normal;letter-spacing: -0.6px;">
                안녕하세요, '.$nick.'님.<br>
                비밀번호 재설정을 위해 이메일 인증을 진행합니다.<br>
                아래의 인증번호 4자리를 입력란에 정확히 입력해주세요.
                </p>
            </div>
            </div>

            <div style="margin-left:20px;margin-right:20px">
            <div style="margin-bottom:20px;text-align:center"></div>
            </div>

            <!-- 인증 번호 -->
            <div style="margin-bottom:20px;text-align:center">
            <u></u><a style="border: 1px #11e034 solid;border-radius:30px;display:inline-block;font-size:14px;font-weight:bold;line-:1;padding:12px 24px;text-align:center;text-decoration:none!important;color:#ffffff!important;background-color: #1bbd36;font-family:sans-serif;" rel="noreferrer noopener">인증번호 : '.$hash.'</a><u></u>
            </div>

        </div>

        <div style="margin-left:20px;margin-right:20px">
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
        </div>

        </div>

        <!-- 내용 푸터 -->
        <div style="text-align:left;color:#60666d;font-size:14px;line-height:21px;font-family:sans-serif;max-width:600px;min-width:320px;width:320px;width:calc(28000% - 167400px);background-color: #e0ffe7;">
        <div style="margin-left:20px;margin-right:20px;">
            <div>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            <p style="margin-top:0;margin-bottom:0;text-align:center;color:rgba(0,0,0,0.65);font-family:sans-serif;font-size: 14px;font-style: normal;font-stretch: normal;letter-spacing: -0.6px;">이 이메일은 발신전용 메일입니다.</p>
            <p style="margin-top:0;margin-bottom:0;text-align:center;color:rgba(0,0,0,0.65);font-family:sans-serif;font-size: 14px;font-style: normal;font-stretch: normal;letter-spacing: -0.6px;">
            문의: seah.ahn.nt@gmail.com</p>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            <div style="line-height:10px;font-size:1px">&nbsp;</div>
            </div>
        </div>
        </div>

    </div>
    </div>

    <!-- 푸터 -->
    <div>
    <div style="margin:0 auto;max-width:600px;min-width:320px;width:320px;width:calc(28000% - 167400px);word-wrap:break-word;word-break:break-word">
        <div style="border-collapse:collapse;display:table;width:100%">
        <div style="text-align:left;font-size:12px;line-height:19px;color:#b8b8b8;font-family:sans-serif;max-width:600px;min-width:320px;width:320px;width:calc(28000% - 167400px)">
            <div style="margin-left:20px;margin-right:20px;margin-top:20px;margin-bottom:20px">

            <div style="font-size:12px;line-height:20px">
                <strong style="color:rgba(0,0,0,0.85);font-family:sans-serif;font-size: 14px;font-style: normal;font-stretch: normal;letter-spacing: -0.6px;">Gyeong-ho Ahn</strong>
                <p style="color:rgba(0,0,0,0.7);font-family:sans-serif;font-size: 12px;letter-spacing:-0.5px;font-style: normal;font-stretch: normal;font-weight:normal;margin-top:0">서울특별시 동작구 사당로13길 36</p>
                <p style="color:rgba(0,0,0,0.5);font-family:sans-serif;font-size: 11px;letter-spacing:normal;font-style: normal;font-stretch: normal;font-weight:normal;">COPYRIGHT Gyeong-ho Ahn ALL RIGHTS RESERVED</p>
            </div>

            </div>
        </div>
        </div>
    </div>
    </div>

    

    </td></tr></tbody></table>
    ';    // 메일 내용

    // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
    // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
    $mail -> SMTPOptions = array(
        "ssl" => array(
            "verify_peer" => false
            , "verify_peer_name" => false
            , "allow_self_signed" => true
        )
    );

    // 메일 전송
    $mail -> send();

    // DB에 사용자 비번과 해쉬값 정보 저장
    $mq = mq("UPDATE user set
                hashv = '$hash'
                WHERE
                email = '$email'
                ");

    $response = [
        'result'   => true,
        'msg' => "메일 발송이 완료되었습니다."
    ];

    echo json_encode($response);
    
} catch (Exception $e) {
    echo $e;

    $response = [
        'result'   => false,
        'msg' => "메일 발송 실패 : 서버 오류"
    ];

    echo json_encode($response);

}
?>