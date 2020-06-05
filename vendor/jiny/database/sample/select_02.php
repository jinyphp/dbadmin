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
$query = "SELECT * from board where id=:id";
$data = [
    'id' => 1
];

$rows = $db->select($query, $data)->fetchAll();
print_r($rows);
