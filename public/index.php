<?php
$config = include "../dbconf.php";
require "../Loading.php";

// 세션 활성화
session_start();


$uri = $_SERVER['REQUEST_URI'];
$uris = explode("/",$uri); // 파란책
// print_r($uris);

$db = new \Module\Database\Database( $config );

if(isset($uris[1]) && $uris[1]) {
    // 컨트롤러 실행...
    // echo $uris[1]."컨트롤러 실행...";
    $controllerName = "\App\Controller\\" . ucfirst($uris[1]);
    $tables = new $controllerName ($db);
    
    // 클래스의 메인이 처음으로 동작하는 것로 정해요.
    $tables->main();

} else {
    // 처음 페이지 에요.
    // echo "처음 페이지 에요.";
    $body = file_get_contents("../Resource/index.html");

    if($_SESSION["email"]) {
        // 로그 상태 입니다.
        $body = str_replace("{{Login}}","로그인 상태입니다. <a href='logout'>로그아웃</a>",$body);
    } else {
        // 로그인 해주세요.
        $loginForm = file_get_contents("../Resource/login.html");
        $body = str_replace("{{Login}}",$loginForm,$body);
    }
    echo $body;
}

// $desc = new \App\Controller\TableInfo;
// $desc->main();