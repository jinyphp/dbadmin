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
 * Raw쿼리를 이용하여 테이블을 생성합니다.
 */

$query = "CREATE TABLE board1 (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` varchar(255),
    `CREATED_AT` datetime,
    `UPDATED_AT` datetime,
    PRIMARY KEY(id)
    ) ENGINE=InnoDB CHARSET=utf8";

$stmt = $db->execute($query);

/**
 * 테이블 목록 표시
 */
$tables = $db->show('TABLES');
print_r($tables);
