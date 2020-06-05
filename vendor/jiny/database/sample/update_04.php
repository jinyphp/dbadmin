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
$db->table("board");

// 갱신할 데이터를 선택합니다.
$data = [
    'id'=>1,
    'title' => 'hello world03'
];
$builder = $db->table("board")->updateId($data,1);
$query = $builder->getQuery();
echo $query;

$builder->run($data);



/**
 * 쿼리빌더
 */


 /*
$data = [
    'regdate' => date('Y-m-d H-i:s'),
    'title' => 'test1',
    'username' => 'test1'
];
$db->table("board")->updateId($data,3, Table::TABLE_CREATE);

echo Table::TABLE_CREATE;
*/

/*




$table = "board5";




if ($rows = $db->table($table)->select()) {
    print_r($rows);
}
*/
