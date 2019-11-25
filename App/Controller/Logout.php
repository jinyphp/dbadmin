<?php
namespace App\Controller;
class Logout
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
        echo "로그아웃을 합니다.";
        $_SESSION["email"] = "";  //공백으로 제거함. 
        
        // 페이지 이동
        header("location:"."/");
    }

}