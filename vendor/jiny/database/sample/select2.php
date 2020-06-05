<?php
const ROOT = "";
require __DIR__.ROOT."/vendor/autoload.php";

// DB를 초기화 합니다.
const DBINFO = "dbconf.php";
$db = \Jiny\Database\db_init(DBINFO);

if ($rows = $db->select("SELECT * from board5 WHERE id = :id",['id'=>3])) {
    print_r($rows);
}