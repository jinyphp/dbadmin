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
 * 목록을 출력합니다.
 */
// 방법1
// $db->execute("SELECT * from board");
// $rows = $db->fetchAll();

// 방법2
$rows = $db->execute("SELECT * from board")->fetchAll();
print_r($rows);
