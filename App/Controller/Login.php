<?php
namespace App\Controller;
class Login
{
    public function __construct()
    {
        // 초기화
    }

    // 1. 언어 정해서 동작방식 (c언어, 자바)
    // 2. 개발자 직접 정하는 방법 (프레임워크.. index / home / main .....)
    public function main()
    {
        // 처음 시작 메소드.
        echo "로그인을 체크해요.";
        // $_POST; <<< PHP 언어 정해진것. 슈퍼변수(배열)
        // print - 문자열
        // print_r - 배열
        print_r($_POST);
        
        // 관리자 계정정보
        $email = "daelim@gmail.com";
        $password = "multi1004";

        if($_SESSION["email"]) {
            echo "로그인 상태입니다.";

        } else {
            // 로그인 체크 및 저장
            if ($_POST) {
                if($_POST['email'] == $email && $_POST['password'] == $password) {
                    echo "로그인 성공";
                    // 세션 슈퍼변수. 값 저장
                    $_SESSION["email"] = $_POST['email'];
                    echo "세션 저장 성공";

                    // 페이지 이동
                    header("location:"."/databases");
                } else {
                    echo "로그인 실패";

                    // 페이지 이동
                    header("location:"."/");
                }
            }
        }
        
        

    }

}