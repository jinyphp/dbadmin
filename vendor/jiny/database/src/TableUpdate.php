<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

trait TableUpdate
{
    /**
     * 업데이트 SQL 쿼리 생성
     */
    public function updateQuery(array $data) :string
    {
        // 컬럼필드 정리
        $this->setFields($data);

        $query = "UPDATE ".$this->name()." SET ";
        foreach ($data as $field => $value) {
                $query .= "`".$field."` = :".$field." ,";
        }

        // 갱신필드 날짜 변경
        $query .= "".self::UPDATED_AT." = '".date("Y-m-d H:i:s")."' ,";

        return rtrim($query,',');
    }

    /**
     * 테이블 전체갱신
     */
    public function updateAll($data)
    {
        $this->action = "update";
        if ($this->_table) {
            // 쿼리빌더 실행
            unset($data['id']); // id를 제외하고 쿼리 빌더 실행
            $this->query = $this->updateQuery($data);
            return $this;
        } else {
            echo "테이블명이 없습니다.";
            exit;
        }
    }

    function updateNew($data)
    {
        $this->action = "updateNew";
        //echo ">>>".$this->action."\n";
        // 데이터 확인
        $stack = clone $this;
        $query = $stack->selectId($data)->getQuery();
        //echo "stack>>".$query."\n";

        $stack->run(['id'=>$data['id']]);
        
        if($rows = $stack->fetch()){
            //print_r($rows);
            // exit;
            //echo "데이터 갱신\n";
            $this->updateId($data);
        } else {
            //echo "데이터가 없습니다.\n";
            $this->insert($data);
        }

        return $this;
    }

    public function updateInc($field, $num=1)
    {
        if ($this->_table) {
            $query = "UPDATE ".$this->name()." SET ";
            $query .= "`".$field."` = `".$field."` + $num WHERE `id` = :id";
            $this->query = $query;

            return $this;
        }
        
    }

    /**
     * id 갱신
     */
    function updateId($data, $id=null, $opt=null)
    {
        $this->action = "update";
        if ($this->_table) {
            unset($data['id']); // id를 제외하고 쿼리 빌더 실행
            $this->query = $this->updateQuery($data);

            // 조건을 추가합니다.
            $this->query .= " WHERE Id=:id";

            return $this;
        } else {
            echo "테이블명이 없습니다.";
            exit;
        }

        /*
        if ($this->_table) {
      
            $stmt = $this->conn->prepare($query);
            $data['id'] = $id;
            $stmt = $this->bindParams($stmt, $data);
            
            if(($e = $this->exec($stmt)) !== true) {
                echo $e->getCode();
                echo $e->getMessage();

                switch($e->getCode()){
                    case '42S02': // 테이블 없음
                    if ($opt & self::TABLE_CREATE) {
                        // 필드 생성
                        foreach(array_keys($data) as $key) {
                            $fields[$key] = 'text';
                        }

                        // 테이블을 생성합니다.
                        $this->fields($fields);
                        //if($create['ENGINE']) $tb->engine("InnoDB");
                        //if($create['CHARSET']) $tb->charset("utf8");
                        $this->create();
                    }
                    break;

                    case '42S22': // Column not found

                    break;
                }
            } else {
                // DB 작업 성공
                $count = $stmt->rowCount();

                if($count>0){
                    echo "성공";
                } else {
                    echo "실패";
                }
            }

            echo "\n\n";
            // echo $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
            // echo $this->conn->getAttribute(PDO::MYSQL_ATTR_FOUND_ROWS);
            // PDO::
        }
        */
    }


    /**
     * 조건문으로 갱신
     */
    private function updateWhere($data, $where)
    { 
        $query = $this->queryUpdate($data);
        $query .= $this->where($where);

        $this->query = $query;
        return $this;
        
        /*
        $query .= " WHERE ";

        foreach ($where as $k => $v) {
            $query .= $k."= :".$k." and ";
        }
        $query = rtrim($query,'and ');

        $stmt = $this->conn->prepare($query);
        $this->bindParams($stmt, $where);   // 조건

        return $stmt;
        */
    }




    /*
        if($this->isAssoArray($data) && $where) {
            if (!$this->conn) $this->connect();

            // 연관배열 데이터
            if(is_numeric($where)) {
                $id = intval($where);
                $stmt = $this->updateId($data, $id);
            } else 
            if(is_string($where)) {
                switch ($where) {
                    case '*':
                        $stmt = $this->updateAll($data);
                        break;
                    default:
                        $stmt = $this->updateQuery($data, $where);
                }
            } else 
            if(is_array($where)) {
                $stmt = $this->updateWhere($data, $where);
            }

            $this->bindParams($stmt, $data);
            if(($e = $this->exec($stmt)) !== true) {
                // 오류 처리
            }

        } else {
            // 숫자 배열
            // 재귀호출 반복실행
            foreach ($data as $k => $v) {
                if(is_numeric($k)) $this->update($v, $k);
            }
        }   
        */  
}