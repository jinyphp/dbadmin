<?php
// 자동으로 require 해주는 기능
// 이 기능을 등록해 준다. //익명함수
spl_autoload_register(function($classname){
    // echo $classname;
    // 클래스 이름을 조합해서, require 해준다.
    require "../".$classname.".php";
    // exit;
});