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
 * 쿼리빌더 
 */
$build = $db->table("board3"); // 쿼리빌더 생성

$fields = [
    'id'=>'int(11)',
    'title'=>'varchar(255)',
    'created_at'=>'datetime',
    'updated_at'=>'datetime'
];

$build->create($fields)->run();

/**
 * 테이블 목록 표시
 */
$tables = $db->show('TABLES');
print_r($tables);


