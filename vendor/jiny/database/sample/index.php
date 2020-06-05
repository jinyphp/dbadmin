<?php

namespace Jiny\Database;

echo __DIR__;

require __DIR__."/../src/Database.php";
require __DIR__."/../src/table.php";

const DBINFO = "dbconf.php";

if (file_exists(DBINFO)) {
    $dbconf = include DBINFO;
    $db = new \Jiny\Database\Database($dbconf);
} else {
    echo "DB 설정파일이 없습니다.";
    exit;
}

$table = "board5";

/*
$titleText = "셈플입력입니다.";
$data = [
    'regdate' => "aaaa",
    'title' => htmlspecialchars(strip_tags($titleText)),
    'bbb' => 'test',
    'ccc' => '필드 추가됨'
];
$db->insert($table, $data, true, ['ENGINE'=>'InooDB','CHARSET'=>'utf8']);
*/



// 아디디 갱신
$data1 = [
    '1'=>[
        'regdate' => date('Y-m-d H-i:s'),
        'title' => '수정111'
    ],
    '2'=>[
        'regdate' => date('Y-m-d H-i:s'),
        'title' => '수정222'
    ]
    
];

$db->update($table, $data1);


/*
$data2 = [
    'regdate' => date('Y-m-d H-i:s'),
    'title' => '수정222'
];

$db->updateWhere($table, $data2, ['id'=>2, 'bbb'=>'test']);
*/

// 목록을 출력
if ($rows = $db->select($table,['regdate','title'], ['Id'=>'1'])) {
    print_r($rows);
}



exit;




// 테이블 생성관리
// $db->create();
// $db->createTable("board2");
$db->dropTable("board2");

$fields = [
    'id'=>'int(11)',
    'title33'=>'varchar(255)',
    'created_at'=>'datetime',
    'updated_at'=>'datetime'
];

$tb = ( new queryTable() )->name("board2")->fields($fields)->engine("InnoDB")->charset("utf8");
$db->createTable($tb);

$tables = $db->showTables();
print_r($tables);

exit;





