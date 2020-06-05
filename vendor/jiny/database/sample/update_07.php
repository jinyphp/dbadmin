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

// 쿼리빌더 객체를 생성합니다.
$builder = $db->table("board10");

// 갱신할 데이터를 선택합니다.
$data = [
    'id'=>11
];

$query = $builder->updateInc("click", $num=1)->getQuery();
//$query = $builder->createAuto()->updateNew($data)->getQuery();
echo $query;

$builder->run($data);

