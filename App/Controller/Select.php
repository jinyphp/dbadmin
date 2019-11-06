<?php
namespace App\Controller;
class Select
{
    private $db; 
    private $HttpUri;
    private $html ;
    //생성자
    public function __construct($db)
    {
        $this->db = $db;
        $this->HttpUri = new  \Module\Http\Uri(); //클래스 생성후 HttpUri에 삽입
        $this->html = new \Module\Html\HtmlTable;
    }
    /**
     * 처음 동작 구분 처리
     */
    public function main()
    {
        $tablename = $this->HttpUri->second();
        //3번째 데이터 값에 데이터가 없을경우 생성 있을경우 출력
        if($this->HttpUri->third() == "new"){
            echo "새로운데이터 입력";
            $this->newInsert($tablename);
        } else {

        $this->list($tablename);
        }
    }
    
    /**
     * 새로운 데이터 입력 처리
     */
    public function newInsert($tablename)
    {   
        //$_POST = 슈퍼변수 값을 받아온다
        //print_r($_POST);
        if($_POST){
            $query = "INSERT INTO ".$tablename." (`FirstName`,`LastName`) 
                    VALUES ('".$_POST['firstname']."','".$_POST['lastname']."')";
            $result = $this->db->queryExecute($query);
            header("location:"."/select/".$tablename);
        }
        $query = "DESC ".$tablename;
        $result = $this->db->queryExecute($query);

        $count = mysqli_num_rows($result);
        $content = ""; // 초기화
        $rows = []; //배열초기화
        for($i=0;$i<$count;$i++){
            $row =mysqli_fetch_object($result);
            $rows []=$row; //배열 추가 (2차원 배열)
        }
        $content = $this->html->table($rows);

        $body = file_get_contents("../Resource/insert.html");
        $body = str_replace("{{content}}",$content,$body); //데이터 치환
        echo $body;
    }
    public function list($tablename)
    {
       if($tablename){ 
           //uri[2]가 존재하고 uri[2]값이 존재하는지확인
           $query = "SELECT * from ".$this->HttpUri->second(); //SQL쿼리문
           $result = $this->db->queryExecute($query); //DB접속후 쿼리문 실행 
           
           $content = ""; // 초기화
           $rows = []; //배열초기화
           $count = mysqli_num_rows($result);
           if($count){ 
               // $count 값이 0보다 클경우 true
               for($i=0;$i<$count;$i++){
                   $row =mysqli_fetch_object($result);
               // print_r($row);
               $rows []=$row; //배열 추가 (2차원 배열)
               $content = $this->html->table($rows);
               }
           } else{
               //데이터가 없음
               $content = "데이터 없음";
           }
       } else{
       $content = "선택한 테이블이 없습니다.";
       }
       $body = file_get_contents("../Resource/select.html");
       $body = str_replace("{{content}}",$content,$body); //데이터 치환
       echo $body;
    }
}