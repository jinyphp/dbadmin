<?php

namespace Jiny\Database;

use PDO;

class Builder
{
    private $conn;
    private $db;
    private $table;

    private $_fields = [];
    private $_wheres = [];

    private $query = "";

    public function __construct($table)
    {
        $this->table = $table;
        $this->conn = $table->conn();
        $this->db = $table->db();
    }

    

    public function fields($fields)
    {
        if($fields) {
            foreach ($fields as $f => $v) {
                $this->_fields[$f] = $v;
            }
        }
        
        return $this;
    }

    public function wheres($fields)
    {
        foreach ($fields as $f => $v) {
            $this->_wheres[$f] = $v;
        }
        return $this;
    }


    public function exec()
    {
        $stmt = $this->conn->prepare($this->query);

        $this->table->bindParams($stmt, $this->_wheres);
        $this->table->bindParams($stmt, $this->_fields);

        // echo "쿼리=".$this->query."<br>";
        // print_r($this->_wheres);
        // print_r($this->_fields);
        // var_dump($stmt);
        

        if(($e = $this->db->exec($stmt)) !== true) {
            // 오류 처리
        }
    }

    

    /**
     * 
     */


}
