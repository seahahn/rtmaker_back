/* 필수 입력 채우지 않았을 경우 경고창 띄우기*/
function check_input() {
    if(!$("#usergroup0").prop("checked") && !$("#usergroup1").prop("checked")){
        alert("회원 구분을 선택해주세요.");
        return;
    }

    if(!$("#email").val()){
        alert("이메일 주소를 입력해주세요.");                    
        $("#email").focus();
        return;
    }

    if($("#email_check_msg").attr("data-check") != "1"){
        alert("중복된 이메일입니다.");
        $("#email").focus();
        return;
    }

    if(!$("#password").val()){
        alert("비밀번호를 입력해주세요.");
        $("#password").focus();
        return;
    }

    if(!$("#pw_confirm").val()){
        alert("비밀번호 확인을 입력해주세요.");
        $("#pw_confirm").focus();
        return;
    }

    if($("#password").val() != $("#pw_confirm").val()){
        alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
        $("#password").focus();
        $("#password").select();
        return;
    }

    if($("#pw_check_msg").attr("data-check") != "1"){
        alert("올바른 비밀번호 형식이 아닙니다.");
        $("#password").focus();
        return;
    }

    if(!$("#name").val()){
        alert("이름을 입력해주세요.");
        $("#name").focus();
        return;
    }

    if(!$("#checkbox-agree_term").prop("checked")){
        alert("이용약관에 동의해주세요.");
        return;
    }

    document.formSignupKR.submit();
}

/* 이메일 입력 여부 및 형식 검증 */
$(function(){
    $("#email").blur(function(){
        var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; // 이메일 형식 검증식
        if($(this).val()==""){
            $("#email_check_msg").html("이메일을 입력해주세요.").css("color", "red").attr("data-check", "0");
            $(this).focus();
        } else if(!regEmail.test(($(this)).val())){
            $("#email_check_msg").html("올바른 이메일 주소가 아닙니다.").css("color", "red").attr("data-check", "0");
            $(this).focus();
        } else {
            checkEmailAjax();
            // $("#email_check_msg").html("사용 가능한 이메일입니다.").css("color", "blue").attr("data-check", "1");                            
        }
    });
});

/* 비밀번호 입력 및 일치 여부 검증 */
$(function(){
    $("#pw_confirm").blur(function(){
        var regPw = /^((?=.*\d)|(?=.*\W)).{8,16}$/; // 비번 형식 검증식
        // var regPw = /^(?=.*[a-zA-Z])((?=.*\d)|(?=.*\W)).{8,16}$/; // 비번 형식 검증식
        // var regPw = /^.*(?=^.{8,16}$)([a-zA-Z]|[0-9]|[~!@#$%^&*()_+|<>?:{}]).*$/; // 비번 형식 검증식
        // var regPw = /^.*(?=^.{8,16}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/; // 비번 형식 검증식
        if($("#password").val()==""){
            $("#pw_check_msg").html("비밀번호를 입력해주세요.").css("color", "red").attr("data-check", "0");
            $("#password").focus();
        } else if($(this).val()==""){            
            $("#pw_check_msg").html("비밀번호 확인을 입력해주세요.").css("color", "red").attr("data-check", "0");
            $(this).focus();
        } else if($(this).val() != $("#password").val()){
            $("#pw_shape").css("color", "silver").attr("data-check", "0");
            $("#pw_check_msg").html("비밀번호가 일치하지 않습니다.").css("color", "red").attr("data-check", "0");
        } else if(!regPw.test(($(this)).val()) || !regPw.test($("#password").val())) {
            $("#pw_shape").css("color", "red").attr("data-check", "0");
            $("#pw_check_msg").html("올바른 비밀번호 형식이 아닙니다.").css("color", "red").attr("data-check", "0");
        } else {    
            $("#pw_shape").css("color", "silver").attr("data-check", "0");
            $("#pw_check_msg").html("비밀번호가 일치합니다.").css("color", "blue").attr("data-check", "1");
        }
    });
});

/* 이메일 중복 체크(비동기통신)*/
function checkEmailAjax(){
    $.ajax({
        url : "./check_email.php",
        type : "POST",
        dataType : "JSON",
        data : {
            "email" : $("#email").val()
        },
        success : function(data){
            if(data.check){
                $("#email_check_msg").html("사용 가능한 이메일입니다.").css("color", "blue").attr("data-check", "1");                            
            } else {
                $("#email_check_msg").html("중복된 이메일입니다.").css("color", "red").attr("data-check", "0");
                $("#email").focus();                            
            }
        }
    });
}