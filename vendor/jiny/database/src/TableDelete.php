<?php

namespace Jiny\Database;

use PDO;
use \Jiny\Database\Builder;

trait TableDelete
{
    /**
     * 데이터를 삭제합니다.
     */
    public function deleteAll()
    {
        $this->action = "delete";
        if ($this->_table) {
            $this->query = "DELETE FROM ".$this->name()." ";
        }
        return $this;
    }

    /**
     * 데이터를 삭제합니다.
     */
    public function deleteId($id)
    {
        $this->action = "delete";
        if ($this->_table) {
            return $this->builder->delete();
        } else {
            echo "테이블명이 없습니다.";
            exit;
        }

        /*
        if (!$where) {
            echo "삭제 조건이 없습니다.";
            exit;

        } else if (is_string($where)) {
            switch ($where) {
                case '*':
                    // 전체 삭제
                    $query = "DELETE FROM ".$this->_table." ";
                    $stmt = $this->conn->prepare($query);
                    $this->exec($stmt);
                    break;
                
                default:
                    $query = "DELETE FROM ".$this->table." WHERE ".$where;
                    $stmt = $this->conn->prepare($query);
                    $this->exec($stmt);
                    break;
            }
        } else if (is_numeric($where)) {
            // 단일 아이디 선택
            $query = "DELETE FROM ".$this->_table." WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $id = htmlspecialchars(strip_tags($where));
            $stmt->bindParam(':id', $id);

            $this->exec($stmt);

        } else if (is_array($where)) {
            $query = "DELETE FROM ".$this->_table." WHERE ";

            foreach ($where as $id) {
                $query .= '`id` = ? or ';
            }

            $query = rtrim($query,'or ');
            $stmt = $this->conn->prepare($query);

            $this->exec($stmt,$where);
        }
        */

    }

    
    /**
     * 
     */
}