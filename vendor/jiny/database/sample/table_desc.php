<?php
require "../../../../vendor/autoload.php";

// DB를 초기화 합니다.
$dbinfo = \Jiny\Database\db_conf("dbconf.php");
$db = \Jiny\Database\db_init($dbinfo);
if ($db) {
    echo "db 접속 성공\n";
} else {
    echo "db 접속 실패\n";
}

// board2 테이블의 정보를 확인합니다.
if(!$desc = $db->desc('board2')) {
    echo "테이블의 정보를 읽어 올 수 없습니다.";
    exit;
}
print_r($desc);