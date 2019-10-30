<?php
$config = include "../dbconf.php";
echo "대림대학교";
print_r($config);

require "../Module/Database/database.php"; // 1개
require "../Module/Database/table.php"; // 2개

$db = new Database( $config );
echo "<br>";
$query = "SHOW TABLES";
$result = $db->queryExecute($query);

$count = mysqli_num_rows($result);
for ($i=0;$i<$count;$i++) {
    $row = mysqli_fetch_object($result);
    echo $row->Tables_in_php."<br>";
}