<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

trait TableInsert
{
    public function insertQuery(array $data=[]) :string
    {
        $this->setFields($data);

        $query = "INSERT INTO ".$this->name()." SET ";
        foreach ($data as $field => $value) {
                $query .= $field."= :".$field." ,";
        }

        $query .= self::CREATED_AT."= '".date("Y-m-d H:i:s")."' ,";
        $query .= self::UPDATED_AT."= '".date("Y-m-d H:i:s")."' ,";

        return rtrim($query,',');
    }

    public function insert(array $data)
    {
        $this->action = "insert";
        // 연상배열 여부 체크
        if(!isAssoArray($data)) {
            // 다중처리
            $this->query = $this->insertQuery($data[0]);

        } else {
            // 단일처리
            $this->query = $this->insertQuery($data);       
        }
        return $this; 
    }

    /*
$stmt = $this->conn->prepare($query);
            $this->bindParams($stmt, $data);
            if(($e = $this->exec($stmt)) !== true) {
                switch($e->getCode()) {
                    case '42S22':
                        // 컬럼 필드 매칭오류
                        if($matching) {
                            // 자동으로 필드를 추가합니다.
                            $this->autoField($data);

                            // 다시 재귀 실행으로 데이터를 삽입을 처리합니다.
                            $this->insert($data);
                            return;
                        } 
                        break;
                    
                    // 테이블 없음.
                    case '42S02':
                        if($create) {
                            // 필드 생성
                            foreach(array_keys($data) as $key) {
                                $fields[$key] = 'text';
                            }

                            // 테이블을 생성합니다.
                            $this->fields($fields);
                            if($create['ENGINE']) $tb->engine("InnoDB");
                            if($create['CHARSET']) $tb->charset("utf8");
                            $this->create();

                            // 다시 재귀 실행으로 데이터를 삽입을 처리합니다.
                            $this->insert($data);

                            return;

                        }
                        break;
                    default:
                }

                echo "Database Error: 코드".$e->getCode()."\n";
                echo $e->getMessage()."\n";
                exit;
            }
    */

}