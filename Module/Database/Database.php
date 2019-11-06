<?php
namespace Module\Database;
// 선언 -> 생성 -> 호출
// 데이터베이스 선언
class Database
{
    public $connect;
    //복합객체 - 객체지향의 은닉화
    private $Table;
    public function setTable($name)
    {
        $this->Table = $name;
        return $this;
    }
    public function getTable()
    {
        return $this->Table;
    }
    //생성자 메소드(함수)
    public function __construct($config)   //생성자 역할
    {
        //테이블 객체 연결
        $this->Table = new \Module\Database\Table($this);
        //echo "클래스 생성 <br>";
        // 전역 네임스페이스
        // mysql 접속
        $this->connect = new \mysqli($config['host'], $config['user'], $config['passwd'], $config['database']);
        //성공 : connect_errno = 0
        //실패 : connect_errno = 1
        if(!$this->connect->connect_errno){   //connect_errno 는 프로퍼티. 이 값에 에러가 있다면 false.
            //echo "DB 접속 성공입니다. <br>";  // !를 줘서 결과 반전
        } else {
            echo "DB 접속이 안됩니다. <br>";
        }
    }
    public function queryExecute($query)
    {
        if($result = mysqli_query($this->connect,$query)){
            //echo "쿼리 성공 <br>";
        } else {
            print "쿼리 실패 <br>";
        }
        return $result;
    }
    //테이블 확인
    public function isTable($tablename)
    {
        $query = "SHOW TABLES;";
        $result = $this->queryExecute($query);

        $count = mysqli_num_rows($result);

        for($i=0; $i<$count; $i++){
            $row = mysqli_fetch_object($result);
            if($row->Tables_in_php == $tablename ){
                return true;
            }
            echo "테이블=".$row->Tables_in_php."<br>";
        }
        return false;
    }
}