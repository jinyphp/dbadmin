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
 * 데이터를 수정합니다.
 */
$query = "UPDATE board SET title=:title where id=:id";
$data = [
    'id' => 1,
    'title' => 'hello world11'
];

$stmt = $db->update($query, $data);

if($db->updateCheck()) {
    echo "성공";
} else {
    echo "실패";
}


