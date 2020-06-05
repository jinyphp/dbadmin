<?php
const ROOT = "";
require __DIR__.ROOT."/vendor/autoload.php";

// DB를 초기화 합니다.
const DBINFO = "dbconf.php";
$db = \Jiny\Database\db_init(DBINFO);

$table = "board5";
$data1 = [
    'regdate' => date('Y-m-d H-i:s'),
    'title' => '수정33333'
];

$db->table($table)->update($data1,3);

if ($rows = $db->table($table)->select()) {
    print_r($rows);
}