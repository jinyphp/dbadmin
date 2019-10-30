<?php
namespace App\Controller;
class TableInfo
{
    private $db;
    // 생성자
    public function __construct($db)
    {
        // echo __CLASS__;
        $this->db = $db;
    }

    public function main()
    {
        // echo "메인 호출이에요.";
        $query = "DESC members";
        $result = $this->db->queryExecute($query);

        $count = mysqli_num_rows($result);
        $content = ""; // 초기화
        $rows = []; // 배열 초기화
        for ($i=0;$i<$count;$i++) {
            $row = mysqli_fetch_object($result);
            // $rows []= $row; // 배열 추가
            // print_r($row);
            foreach ($row as $r) {
                echo $r. " ";
            }
            echo "<br>";

        }
    }

}
