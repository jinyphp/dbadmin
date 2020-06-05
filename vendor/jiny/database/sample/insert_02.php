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
 * 데이터를 삽입합니다.
 */

$titleText = "raw 셈플입력입니다...";
$data = [
    'regdate' => date('Y-m-d H:i:s'),
    'title' => htmlspecialchars(strip_tags($titleText))
];

// Raw 쿼리 실행
$db->insert("INSERT INTO board5 SET regdate=:regdate, title=:title", $data);

