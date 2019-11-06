<?php

namespace Module\Database;

class Table
{
    public $table_name;
    public $Database;

    public function __construct($database)
    {
        //echo "테이블 클래스 생성 <br>";
        $this->Database = $database;
    }

    //테이블 생성
    public function createTable($name, array $fields)
    {
        echo "테이블을 생성합니다. <br>";
        $query = "
        CREATE TABLE `".$name."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
        ";

            // `LastName` varchar(255),
            // `FirstName` varchar(255),
        foreach($fields as $key => $value){
            $query .= "`$key` $value,"; //key -> First, value -> varchar
        }

        // +=, *=, .=
        $query .= "
            PRIMARY KEY(`id`)
            ) ENGINE=innodb default charset=utf8;
        ";

        mysqli_query($this->Database->connect, $query);
    }
}