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
// 쿼리빌더 테이블 선택
// 존재하지 않는 테이블을 선택합니다.
$builder = $db->table("board5");

// 필드 선택
$fields = ['regdate','title','aaa'];
$query = $builder->select($fields)->getQuery();
echo $query."\n";

// 자동컬럼
$builder->fieldAuto()->run();
$rows = $builder->fetchAll();
print_r($rows);
