<?php

// Modules 우선검색
spl_autoload_register(function($name){
    /*
    // 클래스 파일명 변환
    $namesapce = explode("\\",$name);

    $path = DIRECTORY_SEPARATOR. "modules";
    $path .= DIRECTORY_SEPARATOR. strtolower($namesapce[0]);
    $path .= DIRECTORY_SEPARATOR. strtolower($namesapce[1]);
    $path .= DIRECTORY_SEPARATOR. "src";
    for($i=2; $i<count($namesapce); $i++) {
        $path .= DIRECTORY_SEPARATOR. $namesapce[$i];
    }

    if(file_exists(__DIR__.$path.".php")) {
        require_once(__DIR__.$path.".php");
    } else {
        // echo "파일 읽기 실패";
        // 컴포저 오토로드에서 검색...
    }
    */

});

// Composer Autoload
require __DIR__.DIRECTORY_SEPARATOR."vendor/autoload.php";