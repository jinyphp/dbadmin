<?php
namespace Jiny\Database\Drivers;

class PDO
{
    private $_dbhost = 'localhost';
    private $_dbtype = 'mysql';
    private $_dbcharset = 'utf8';
    
    private $_dbname = null;
    private $_dbuser = null;
    private $_dbpass = null;

    private $conn = null;

    public function __construct($args=null)
    {
        // echo __CLASS__;
        if ($args) {
            extract($args);

            if (isset($host) && $host) $this->_dbhost = $host;
            if (isset($type) && $type) $this->_dbtype = $type;
            if (isset($charset) && $charset) $this->_dbcharset = $charset;

            if (isset($dbname) && $dbname) $this->_dbname = $dbname;
            if (isset($dbuser) && $dbuser) $this->_dbuser = $dbuser;
            if (isset($dbpass) && $dbpass) $this->_dbpass = $dbpass;
        }      
    }

    /**
     * DB 연결
     */
    public function connect()
    {
        if (!$this->conn) {
            if(!$this->_dbtype) {
                echo "DB타입이 선택되어 있지 않습니다.";
                exit;
            } else $host = $this->_dbtype;

            if(!$this->_dbhost) {
                echo "DB 접속 호스트가 설정되어 있지 않습니다.";
                exit;
            } else $host .= ":host=".$this->_dbhost;

            if(!$this->_dbcharset) {
                echo "DB 문자셋이 설정되어 있지 않습니다.";
                exit;
            } else $host .= ";charset=".$this->_dbcharset;

            if(!$this->_dbname) {
                echo "DB명이 설정되어 있지 않습니다.";
                exit;
            } else $host .= ";dbname=".$this->_dbname;

            if(!$this->_dbuser) {
                echo "DB 사용자가 설정되어 있지 않습니다.";
                exit;
            }

            if(!$this->_dbpass) {
                echo "DB 접속암호가 설정되어 있지 않습니다.";
                exit;
            }

            try {
                $this->conn = new \PDO($host, $this->_dbuser, $this->_dbpass);
                
                //오류 숨김모드 해제, Exception을 발생시킨다.
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // echo "DB 접속 성공\n";
    
            } catch(PDOException $e) {
                echo "실패\n";
                echo $e->getMessage();
            }
        }       
        
        // 접속 DB connector를 반환합니다.
        return $this->conn;
    }

    /**
     * DB이름 getter/setter
     */
    public function setDBName($dbname)
    {   
        $this->_dbname = $dbname;
    }

    public function getDBName()
    {
        return $this->_dbname;
    }

    /**
     * 권한접속자 setter
     */
    public function setUser($user)
    {
        $this->_dbuser = $user;
    }

    /**
     * 패스워드 setter
     */
    public function setPassword($pass)
    {
        $this->_dbpass = $pass;
    }

    /**
     * 
     */
}