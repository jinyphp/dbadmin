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

class Tables extends Controller
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
        // 기본값, 현재 스키마의 테이블목록
        return $this->read();
    }

    // 없는 메소드 호출
    public function __call($method, $params)
    {
        return $this->action($method, $params);   
    }

    // 동작구분
    private function action($method, $params)
    {
        if ($this->db->table($method)->is()) {
            // echo "마지막 값은 테이블 입니다.";
            $table = $this->http->endpoint()->last();
            
            return $this->edit($method);
            
        } else if ($this->db->schema()->is($method)) {
            // echo "마지막 값은 스키마 입니다.";
            $schema = $this->http->endpoint()->last();  

            $this->db->query("USE ".$schema);
            $this->db->setSchema($schema);

            return $this->read($schema);

        } else {
            return $method."는 존재하지 않는 테이블 입니다..";
            exit(1);
        }    
    }

    /**
     * 테이블 목록
     */
    private function read()
    {

        // 목록 조회
        $this->db->query("SHOW TABLES"); // 테이블 목록쿼리
        
        $rows = []; // 배열 초기화
        while ($row = $this->db->fetchAssoc()) {
            // print_r($row);
            $rows []= array(
                'Table'=>$row["Tables_in_".$this->db->getSchema()], // 테이블명만 추출  
                'Desc'=>$row["Tables_in_".$this->db->getSchema()],
                'Edit'=>$row["Tables_in_".$this->db->getSchema()],
            );        
        }

        // 테이블 빌더
        $table = \jiny\factory("\Jiny\Html\Table", $rows);
            $table->setClass("table table-striped"); // 부트스트랩4 css class 추가

            // 테이블 정보목록으로 링크
            $table->setHref('Table', ['field'=>"Table", 'url'=>"/select"]); // 링크설정, 대소문자 구별
            $table->setHref('Desc', ['field'=>"Desc", 'url'=>"/desc"]);
            $table->setHref('Edit', ['field'=>"Edit", 'url'=>"/tables"]);

        $body = file_get_contents("../Resource/view/table.html");
        $body = str_replace("{{content}}", $table->build(), $body); // 데이터 치환

        return $body;
    }

    /**
     * 신규 테이블 추가
     */
    public function new()
    {
        if ($this->http->method() == "POST") {
            $this->create_action();
        } else {
            return $this->create_view();
        }        
    }

    private function create_view()
    {
        $content = \jiny\template("../Resource/view/table_new.html");
        $body = \jiny\skin("layout", ['content'=>$content]);
        return $body;
    }

    private function create_action()
    {
        // 새로운 데이터베이스를 추가
        $name = htmlspecialchars($_POST['tablename'], ENT_QUOTES, 'UTF-8');
            
        // 테이블 중복검사
        if (!$this->db->table($name)->is()) {
            $this->db->table($name)->createEmpty();
            \jiny\redirect("/tables"); // 페이지 이동
        } else {
            echo $name."은 이미 등록된 테이블 입니다.";
        } 
    }

    /**
     * 테이블 수정
     */
    public function edit($name=null)
    {
        if ($this->http->method() == "POST") {
            $this->update_action($name);
        } else {

            $content = $this->update_view($name);
            
            $skin = new \Jiny\Theme\Skin();
            $navbar = $skin->navbar();
            $sidemenu = $skin->sidemenu(['menu'=>["목록", "조회", "구조"]]);

            $body = $skin->layout(['content'=>$content, 'navbar'=>$navbar, 'sidemenu'=>$sidemenu]);
            return $body;
        } 
    }

    private function update_view($name)
    {

        $content = \jiny\template("../Resource/view/table_update.html.php",['tablename'=>$name]);
        return $content;
    }

    private function update_action($name)
    {
        // 새로운 데이터베이스를 추가
        $new = htmlspecialchars($_POST['tablename'], ENT_QUOTES, 'UTF-8');
        $this->db->table($name)->rename($name, $new);
        
        \jiny\redirect("/tables"); // 페이지 이동
    }

    /**
     * 
     */
}