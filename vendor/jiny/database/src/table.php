<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

class Table
{
    private $conn;
    private $db;
    private $_table;

    private $_fields = [];
    
    const PRIMARYKEY = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    private $builder;
    private $action;

    use TableCreate, TableSelect, TableInsert, TableUpdate, TableDelete;

    

    /**
     * 빌더 초기화
     */
    public function __construct($conn, $db)
    {
        $this->conn = $conn;
        $this->db = $db;

        // $this->builder = new Builder($this);
    }

    /**
     * database 객체를 참조합니다.
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * 컨넥션 정보를 읽어 옵니다.
     */
    public function conn()
    {
        return $this->conn;
    }

    /**
     * 테이블명
     */
    public function name()
    {
        return $this->_table;
    }

    /**
     * 테이블 이름 설정
     */
    public function setTable($table)
    {
        $this->_table = $table;

        //쿼리 빌더의 인스턴스를 반환
        return $this;
    }

    /**
     * 필드 설정
     */
    public function field($name, $value)
    {
        $this->_fields[$name] = $value;
        return $this;
    }

    // 복수 필드 설정
    public function setFields($fields)
    {
        return $this->fields($fields);
    }

    private function fields($fields)
    {
        foreach ($fields as $f => $v) {
            $this->_fields[$f] = $v;
        }
        return $this;
    }

    /**
     * 빌더 필드 삭제
     */
    public function remove($name)
    {
        unset($this->_feilds[$name]);
        return $this;
    }

    /**
     * 생성된 쿼리를 확인합니다.
     */
    private $query;
    public function getQuery() :string
    {
        return $this->query;
    }

    public function __toString()
    {      
        return $this->query;
    }

    public function clear()
    {
        $this->query = "";
        return $this;
    }

    /**
     * 생성된 쿼리를 실행합니다. 
     */
    private $stmt;
    public function run($data=null)
    {
        //echo "\n쿼리 명령 실행:".$this->query."\n" ;
        //print_r($data);
        // 쿼리 실행을 위해서 statement를 설정합니다.
        $this->stmt = $this->conn->prepare($this->query);
        if($data) {
            if(isAssoArray($data)) {
                //echo "binding\n";
                // 데이터를 바인딩 하여 처리 합니다.
                $this->bindParams($this->stmt, $data);
                $this->exec($this->stmt, $data);
            } else if(is_array($data)) {
                // 복수의 데이터를 바인딩 하여 처리 합니다.
                foreach($data as $d) {
                    $this->bindParams($this->stmt, $d);
                    $this->exec($this->stmt, $data);
                }
            }
        } else {
            // 실행 매개변수 데이터 x
            //echo "단일 데이터\n";
            $this->exec($this->stmt, $data);
        }      

        return $this;
    }

    private function exec($stmt, $data=null)
    {
        try {
            // 실행 결과를 반환합니다.
            if($stmt->execute($data)) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            // 예외 발생
            //echo "예외발생 -----\n";
            //echo $e->getCode()."\n";
            //echo $e->getMessage()."\n";

            $method = "Exception_".$e->getCode();
            if (method_exists($this, $method)) {
                // 예외를 처리 동작을 수행합니다.

                // 현재의 작업을 객체를 백업합니다.
                $stack = clone $this; // 지역변수
                if($this->$method($e)) {
                    // 예외처리 성공
                    // 재실행
                    //echo "\n명령 재실행\n";
                    //echo $stack->getQuery()."\n";
                    //print_r($data);
                    $stack->run($data);
                } else {
                    echo "Database 예외처리 오류";
                    exit;
                }
                
            }            
        }
    }

    /**
     * 복수 bind 처리
     */
    public function bindParams($stmt, $data)
    {
        foreach ($data as $field => &$value) {
            $stmt->bindParam(':'.$field, $value);
        }
        return $stmt;
    }

    /**
     * 자동 테이블 생성 체크
     */
    private $auto_create = false;
    public function createAuto($flag=true)
    {
        $this->auto_create = $flag;
        return $this;
    }

    private $auto_field = false;
    public function fieldAuto($flag=true)
    {
        $this->auto_field = $flag;
        return $this;
    }


    /**
     * Exception 처리 루틴
     */
    private function Exception_42S02($e)
    {
        //echo "테이블이 존재하지 않습니다.\n";
        $memento = clone $this;
        if ($memento->auto_create) {
            //echo "테이블을 생성합니다.\n";
            //print_r($memento->_fields);
            // 동작구분
            if(isAssoArray($memento->_fields)) { 
                // 필드 생성
                foreach(array_keys($memento->_fields) as $key) {
                    $fields[$key] = 'text';
                }              
            } else {
                // 필드 생성
                foreach ($memento->_fields as $key) {
                    $fields[$key] = "text";
                }
            }
            // 테이블 생성
            //print_r($fields);
            $query = $memento->create($fields)->getQuery();
            //echo $query;
            $memento->run();

            //echo "테이블이 생성이 되었습니다.";

            return true;
        }

        /*
        if ($this->auto_create) {
            echo "테이블을 생성합니다.\n";
            print_r($this->_fields);
            // 동작구분
            if(isAssoArray($this->_fields)) { 
                // 필드 생성
                foreach(array_keys($this->_fields) as $key) {
                    $fields[$key] = 'text';
                }              
            } else {
                // 필드 생성
                foreach ($this->_fields as $key) {
                    $fields[$key] = "text";
                }
            }
            // 테이블 생성
            print_r($fields);
            $query = $this->create($fields)->getQuery();
            echo $query;
            $this->run();

            echo "테이블이 생성이 되었습니다.";

            return true;
        }
        */

        return false;
    }

    private function Exception_42S22($e)
    {
        //echo "테이블 필드가 일치하지 않습니다.\n";
        //echo $e->getCode()."\n";
        //echo $e->getMessage()."\n";
        if ($this->auto_field) {
            //echo "필드를 일치 합니다.\n";
            //print_r($this->_fields);
            // 자동으로 필드를 추가합니다.
            $this->autoField($this->_fields);
            return true;
        }
        return false;
    }

    /**
     * 입력 데이터 기준, 자동 필드추가
     */
    private function autoField($data)
    {
        // 컬럼 필드 정보를 읽어 옵니다.
        $desc = $this->db->desc($this->_table);

        if(isAssoArray($data)) {
            // 연상배열
            foreach(array_keys($data) as $key) {
                if(!array_key_exists($key, $desc)) {
                    $this->addField($key);
                }
            }
        } else {
            foreach($data as $key) {
                if(!array_key_exists($key, $desc)) {
                    $this->addField($key);
                }
            }
        }        
    }
    /**
     * 
     */
}