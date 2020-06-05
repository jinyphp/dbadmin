<?php
require "../../../../vendor/autoload.php";

// DB를 초기화 합니다.
$dbinfo = [
    'dbname' => "apitest",
    'dbuser' => "apitest",
    'dbpass' => "123456"
];

$db = \Jiny\Database\db_init($dbinfo);
if ($db) {
    echo "db 접속 성공";
} else {
    echo "db 접속 실패";
}

