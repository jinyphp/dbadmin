<?php
namespace App\Controller;
class Select
{
    private $db;
    private $HttpUri;

    private $Html;

    // 생성자
    public function __construct($db)
    {
        // echo __CLASS__;
        $this->db = $db;
        $this->HttpUri = new \Module\Http\Uri();
        $this->Html = new \Module\Html\HtmlTable;
    }

    /**
     * 처음 동작 구분 처리
     */
    public function main()
    {        
        $tableName = $this->HttpUri->second();
        if ($this->HttpUri->third() == "new") {
            echo "새로운 데이터 입력";
            $this->newInsert($tableName);
        } else {
            $this->list($tableName);
        }        
    }

    /**
     * 새로운 데이터를 입력
     */
    public function newInsert($tableName)
    {

        print_r($_POST);
        if ($_POST) {
            
            $fields = " (";
            $data = "(";
            foreach ($_POST as $key => $value) {
                $fields .= "`".$key."`,";
                $data .= "'".$value."',";
            }

            $fields = rtrim($fields,","); // 마지막 콤마 제거
            $data = rtrim($data,","); // 마지막 콤마 제거
            $fields .= ")";
            $data .= ")";
            ///// $query .= " (`FirstName`,`LastName`)";
            $query = "INSERT INTO ".$tableName . $fields . " VALUES ".$data; 
            // $query .= "('".$_POST['FirstName']."','".$_POST['LastName']."')";
            
            echo $query."<br>";
            // exit;

            $result = $this->db->queryExecute($query);
            
            // 페이지 이동
            header("location:"."/select/".$tableName);
        }

        $content = "<form method=\"post\">";
        // $content .= "<input type=\"text\" name=\"firstname\">";
        // $content .= "<input type=\"text\" name=\"lastname\">";
        $query = "DESC ".$tableName;
        $result = $this->db->queryExecute($query);
        $count = mysqli_num_rows($result);
        for ($i=0;$i<$count;$i++) {
            $row = mysqli_fetch_object($result);
            // $rows []= $row; // 배열 추가 (2차원 배열)
            // $row = 객체
            print_r($row);
            if($row->Field == "id") continue;
            $content .= $row->Field." <input type=\"text\" name=\"".$row->Field."\">";
            $content .= "<br>";
        }
        
        $content .= "<input type=\"submit\" value=\"삽입\">";
        $content .= "</form>";

        $body = file_get_contents("../Resource/insert.html");
        $body = str_replace("{{content}}",$content, $body); // 데이터 치환

        
        echo $body;
    }

    public function list($tableName)
    {        
        if ( $tableName ) {
            $query = "SELECT * from ".$tableName; // SQL 쿼리문
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
        
                $content = $this->Html->table($rows);
            } else {
                // 데이터가 없음.
                $content = "데이터 없음";
            }
        } else {
            $content = "선택된 테이블이 없습니다.";
        }

        $body = file_get_contents("../Resource/select.html");
        $body = str_replace("{{content}}",$content, $body); // 데이터 치환
        
        // 테이블 별로 new 버튼 링크 생성
        $body = str_replace("{{new}}",$tableName."/new", $body); 
        echo $body;
    }

}
