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

/**
 * board 테이블 존재 여부를 확인합니다.
 */
if($db->isTable('board')) {
    echo "테이블이 존재합니다.";
} else {
    echo "테이블이 없습니다.";
}

