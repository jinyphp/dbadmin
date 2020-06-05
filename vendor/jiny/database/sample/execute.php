<?php
const ROOT = "";
require __DIR__.ROOT."/vendor/autoload.php";

// DB를 초기화 합니다.
const DBINFO = "dbconf.php";
$db = \Jiny\Database\db_init(DBINFO);

$table = "board";
$query = $db->table($table)->_select(['regdate','title']);

$rows = $db->execute($query)->fetchAll();

print_r($rows);