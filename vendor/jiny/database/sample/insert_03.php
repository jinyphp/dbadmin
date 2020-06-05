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
 * 데이터 삽입
 */
$builder = $db->table("board");

// 삽입 데이터
$titleText = "셈플입력입니다.";
$data = [
    'regdate' => "aaaa",
    'aa'=>'테스트',
    'title' => htmlspecialchars(strip_tags($titleText))
];

$query = $builder->insert($data)->getQuery();
echo $query;

$builder->run($data);