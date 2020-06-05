<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

trait TableSelect
{
    private function selectQuery($fields = []) :string
    {
        $this->setFields($fields);

        $query = 'SELECT ';

        if ($fields || is_array($fields)) {
            if(isAssoArray($fields)) {
                $s = "";
                foreach ($fields as $k=>$f) $s .= "$k,";
                $s = rtrim($s, ',');
                $query .= $s;
            } else {
                $s = "";
                foreach ($fields as $f) $s .= "$f,";
                $s = rtrim($s, ',');
                $query .= $s;
            }
            
        } else {
            $query .= "*";
        }

        $query .= ' FROM '.$this->db->getDBName().".".$this->name();
        
        return $query;
    }

    public function select($fields=[])
    {
        $this->action = "select";
        if ($this->_table) {
            $this->query = $this->selectQuery($fields);
            return $this;
        } else {
            echo "선택출력할 DB 테이블명이 없습니다.";
            exit;
        }
    }

    public function selectId($field=[])
    {
        $this->select($field);
        $this->queryId();
        return $this;
    }

    /**
     * 쿼리 where 조건 추가
     */
    private $enableWhere = false;
    function where($where=[])
    {
        if ($this->query){
            // 중복실행 여부 체크
            if($this->enableWhere) {
                $query = " and";
            } else {
                $query = " WHERE";
            }
            
            foreach ($where as $k => $v) {
                $query .= " ".$k." = :".$k." and";
            }

            $this->query .= rtrim($query, 'and');
            $this->enableWhere = true;
        }       

        return $this;
    }

    /**
     * 쿼리 Id 추가
     */
    public function queryId()
    {   
        $this->query .= " WHERE id = :id";
        return $this;
    }

    /**
     * 제한설정
     */
    private $enableLimit = false;
    function limit($num, $start=null)
    {
        if ($this->query && !$this->enableLimit){
            if ($start) {
                $this->query .= " LIMIT $num , $start";
            } else {
                $this->query .= " LIMIT $num";
            }
            $this->enableLimit = true;
        }
        return $this;
    }

    /**
     * 데이터 읽기
     */
    public function fetchAll($type=null)
    {
        // PDO::FETCH_NUM : 숫자 인덱스 배열 반환
        // PDO::FETCH_ASSOC : 컬럼명이 키인 연관배열 반환
        // PDO::FETCH_BOTH : 위 두가지 모두
        // PDO::FETCH_OBJ : 컬럼명이 프로퍼티인 인명 객체 반환
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($type=null)
    {
        // 
        if($this->stmt) {
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // echo "stmt 가 없습니다.";
        }
    }

    public function count($field = null, $where=null)
    {
        if ($this->_table) {
           
            $query = $this->select($field)->where($where);
            $query = str_replace("*","count(id)",$query);
            $stmt = $this->conn->prepare($query);

            if ($where) {
                $this->bindParams($stmt, $where);
            }

            $stmt->execute();
            $num = $stmt->fetch();

            return $num['count(id)'];
        } else {
            echo "선택출력할 DB 테이블명이 없습니다.";
            exit;
        }
    }

}