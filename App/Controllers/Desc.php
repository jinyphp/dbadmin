<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Controllers;

use \Jiny\Core\Controller;

class Desc extends Controller
{
    private $db;

    public function __construct()
    {
        // 데이터베이스
        $dbinfo = \jiny\dbinfo();
        $this->db = \jiny\factory("\Jiny\Mysql\Connection", $dbinfo);  
    }

    public function main($params=null)
    {
        echo "데이블을 선택해 주세요.";
        // return $this->list();
    }

    private function list($name)
    {
        $rows = $this->db->table($name)->desc();

        // 테이블 빌더
        $table = \jiny\factory("\Jiny\Html\Table", $rows);
        $table->setClass("table table-striped"); // css class 추가

        $body = file_get_contents("../Resource/view/desc.html");
        $body = str_replace("{{content}}", $table->build(), $body); // 데이터 치환

        $body = str_replace("{{tablename}}", $name, $body);
        return $body;
    }

    public function __call($method, $params)
    {
        // 두번째 인자 테이블명
        if ($this->db->table($method)->is()) {
            if($this->http->endpoint()->third() == "new") {
                // echo "컬럼 추가";
                return $this->new($method);
            } else {
                return $this->list($method);
            }           

        } else {
            return $method."는 존재하지 않는 스키마 입니다.";
        }        
    }

    public function new($tablename)
    {
        if ($this->http->method() == "POST") {
            $this->create_action($tablename);
        } else {
            // 새로운 컬럼
            return $this->create_view($tablename);
        }
    }

    public function create_view($tablename)
    {
        $body = file_get_contents("../Resource/view/desc_new.html");
        $body = str_replace("{{action}}","/desc/".$tablename."/new",$body);
        return $body;
    }

    public function create_action($tablename)
    {
        if ($_POST['fieldtype']) {
            $fieldtype = $_POST['fieldtype'];
        } else {
            $fieldtype = "varchar(255)";
        }

        $query = "ALTER TABLE ".$tablename." add ".$_POST['fieldname']." ".$fieldtype;
        $result = $this->db->query($query);

        // 페이지 이동
        header("location:"."/desc/".$this->http->endpoint()->second());
    }


    /**
     * 
     */

}