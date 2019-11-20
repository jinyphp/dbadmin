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
        $uri = new \Module\Http\Uri;
        if($uri->third() == "new") {
            print_r($_POST);
            if ($_POST) {
                if ($_POST['fieldtype']) {
                    $fieldtype = $_POST['fieldtype'];
                } else {
                    $fieldtype = "varchar(255)";
                }

                $query = "ALTER TABLE ".$uri->second()." add ".$_POST['fieldname']." ".$fieldtype;
                $result = $this->db->queryExecute($query);

                // 페이지 이동
                header("location:"."/TableInfo/".$uri->second());
            }

            // 새로운 컬럼
            $body = file_get_contents("../Resource/desc_new.html");
            $body = str_replace("{{action}}","/TableInfo/".$uri->second()."/new",$body);
            echo $body;
        } else if($uri->third() == "delete") {
            // 테이블 삭제
            $query = "DROP TABLES ".$uri->second();
            echo $query." 테이블을 삭제합니다.";
            $result = $this->db->queryExecute($query);

            // 페이지 이동
            header("location:"."/tables");

        } else if($uri->third() == "init") {
            // 테이블 삭제
            $query = "TRUNCATE TABLE ".$uri->second();
            echo $query." 테이블을 초기화 합니다.";
            $result = $this->db->queryExecute($query);

            // 페이지 이동
            header("location:"."/tables");

        } else {
            // 목록출력
            $this->list();
        }
        
    }

    private function list()
    {
        $html = new \Module\Html\HtmlTable;

        $uri = $_SERVER['REQUEST_URI'];
        $uris = explode("/",$uri); // 파란책

        // echo "메인 호출이에요.";
        $query = "DESC ".$uris[2];
        $result = $this->db->queryExecute($query);

        $count = mysqli_num_rows($result);
        $content = ""; // 초기화
        $rows = []; // 배열 초기화
        for ($i=0;$i<$count;$i++) {
            $row = mysqli_fetch_object($result);
            $rows []= $row; // 배열 추가 (2차원 배열)
        }
        $content = $html->table($rows);

        $body = file_get_contents("../Resource/desc.html");
        $body = str_replace("{{content}}",$content, $body); // 데이터 치환

        $body = str_replace("{{tablename}}",$uris[2], $body);
        echo $body;
    }

}
