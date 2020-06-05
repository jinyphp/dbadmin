<?php
const ROOT = "";
require __DIR__.ROOT."/vendor/autoload.php";

// DB를 초기화 합니다.
const DBINFO = "dbconf.php";
$db = \Jiny\Database\db_init(DBINFO);



$fields = [
    'id'=>'int(11)',
    'title33'=>'varchar(255)',
    'created_at'=>'datetime',
    'updated_at'=>'datetime'
];
$table = "board3";
$db->dropTable($table);

$tb = $db->table($table)->fields($fields)->engine("InnoDB")->charset("utf8")->create();

$tables = $db->show('TABLES');
print_r($tables);

