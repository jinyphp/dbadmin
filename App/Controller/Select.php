<?php
namespace App\Controller;
class Select
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
        $html = new \Module\Html\HtmlTable;

        $uri = $_SERVER['REQUEST_URI'];
        $uris = explode("/",$uri); // 파란책
        // []/[select]/[members]

        if ( isset($uris[2]) && $uris[2] ) {
            $query = "SELECT * from ".$uris[2]; // SQL 쿼리문
            $result = $this->db->queryExecute($query);

            $content = ""; // 초기화
            $rows = []; // 배열 초기화

            $count = mysqli_num_rows($result);
            if ($count) {
                // 0보다 큰값 = true
                for ($i=0;$i<$count;$i++) {
                    $row = mysqli_fetch_object($result);
                    // print_r($row);
                    $rows []= $row; // 배열 추가 (2차원 배열)
                }
        
                $content = $html->table($rows);
            } else {
                // 데이터가 없음.
                $content = "데이터 없음";
            }
        } else {
            $content = "선택된 테이블이 없습니다.";
        }

        
        

        $body = file_get_contents("../Resource/select.html");
        $body = str_replace("{{content}}",$content, $body); // 데이터 치환
        echo $body;
    }

}
