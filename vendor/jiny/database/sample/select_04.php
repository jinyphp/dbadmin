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
$builder = $db->table("board");

// 필드 선택
$fields = ['regdate','title'];
$query = $builder->select($fields)->getQuery();
echo $query."\n";

// 조건추가
$where = ['id'=>1];
$query = $builder->where($where)->getQuery();
echo $query."\n";

// 쿼리 실행
$rows = $builder->run($where)->fetchAll();
print_r($rows);
