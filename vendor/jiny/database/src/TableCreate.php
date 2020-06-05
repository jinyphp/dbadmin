<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

trait TableCreate
{
    /**
     * 테이블 생성 쿼리를 처리 합니다.
     */
    public function create($fields=null)
    {
        if($this->db->isTable($this->_table)) {
            echo "중복 테이블: 생성을 할 수 없습니다.";
            exit;
        }
        
        if(!$fields) $fields = $this->_fields;
        $this->query = $this->createQuery($fields);

        return $this;   
    }

    /**
     * 테이블 생성 SQL 문자열
     * private 내부호출만 가능합니다.
     */
    private function createQuery($fields) : string
    {
        // 기본 필드 중복 생성 방지
        unset($fields[self::PRIMARYKEY]);
        unset($fields[self::CREATED_AT]);
        unset($fields[self::UPDATED_AT]);

        // 쿼리 조합
        $query = "CREATE TABLE ".$this->_table;
        $query .= " (`".self::PRIMARYKEY."` INT NOT NULL AUTO_INCREMENT,";
        
        foreach ($fields as $f => $v) {
            $query .= "`$f` $v,";
        }

        $query .= "`".self::CREATED_AT."` datetime,";
        $query .= "`".self::UPDATED_AT."` datetime,";
        $query .= "PRIMARY KEY(id)) ";

        if ($this->_engine) {
            $query .= "ENGINE=".$this->_engine." ";
        }

        if ($this->_charset) {
            $query .= "CHARSET=".$this->_charset." ";
        }

        return $query;
    }

    /**
     * 엔진 설정
     */
    private $_engine;
    public function engine($engine)
    {
        $this->_engine = $engine;
        return $this;
    }

    /**
     * 문자셋 설정
     */
    private $_charset;
    public function charset($charset)
    {
        $this->_charset = $charset;
        return $this;
    }

    public function addField($field, $type='text')
    {
        if (!$this->conn) $this->connect();

        $query = "ALTER TABLE ".$this->_table." ADD ".$field." ".$type;
        $stmt = $this->conn->prepare($query);
        if(($e = $this->exec($stmt)) !== true) {
            // 오류처리
        }
    }

    /**
     * 
     */
}