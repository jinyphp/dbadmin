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

class Select extends Controller
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
        if ($this->http->endpoint()->second()) {
            // return $this->read();
        } else {
            $msg = "조회할 테이블이 없습니다.";
            return $msg;
        }
    }

    public function __call($method, $params)
    {
        // 두번째 인자 테이블명
        if ($this->db->table($method)->is()) {
            $action = $this->http->endpoint()->third();

            if( $action == "new") {
                // echo "컬럼 추가";
                return $this->new($method);

            } else if($action == "delete") {
                $id = $this->http->endpoint()->forth();
                return $this->delete($method, $id);

            } else 
            // 3번째 값이 정수이면: 수정
            // 문자 -> 숫자 (intval)
            // 숫자 -> 정수??? (is_int)
            if ( is_numeric($action) ) {
                // 데이터 수정
                return $this->edit($method, $action);               
    
            } else {
                return $this->read($method);
            }  
            
            
        } else {
            return $method."는 존재하지 않는 테이블 입니다..";
            exit(1);
        }        
    }


    
    public function read($tablename)
    {        
        if ( $tablename ) {
            $markup = \jiny\htmlMarkup(); //html Markup builder

            // 전체갯수
            $query = "SELECT * from ".$tablename; // SQL 쿼리문
            $total = $this->db->table($tablename)->count($query);
            //echo "천체갯수=".$total;

            $lines = 5;
            $start = $_GET['start']? $_GET['start']:0; //5;
            $start = $start * $lines;

            $query = "SELECT * from ".$tablename; // SQL 쿼리문
            $query .= " LIMIT ".$start.",".$lines;         

            if ($rows = $this->db->query($query)->fetchAssocAll()) {
                // 테이블 빌더
                // $table = \jiny\factory("\Jiny\Html\Table", $rows);
                $table = $markup->table($rows);

                $table->setHref('id', ['field'=>"id", 'url'=>"".$tablename]); // 타이틀필들 table/id값으로 링크
                $content = $table->build();

            } else {
                $content = "데이터가 없습니다.";
            }
            
        } else {
            $content = "선택된 테이블이 없습니다.";
        }

        
        $totalPages = $total / $lines; // 페이지수

        $content .= "<nav aria-label=\"Page navigation example\">
        <ul class=\"pagination\">
          <li class=\"page-item\"><a class=\"page-link\" href=\"#\">Previous</a></li>";

        for ($i=0,$j=1; $i<$totalPages; $i++, $j++) {
            // GET 방식으로 URI를 이용하여 값을 전달함.
            $content .= "<li class=\"page-item\"><a class=\"page-link\" href=\"?start=$i\">$j</a></li>";
        }

        $content .= "<li class=\"page-item\"><a class=\"page-link\" href=\"#\">Next</a></li>
        </ul>
      </nav>";



        $body = file_get_contents("../Resource/view/select.html");
        $body = str_replace("{{content}}",$content, $body); // 데이터 치환
        
        // 테이블 별로 new 버튼 링크 생성
        $btnInsert = $markup->a(['value'=>"데이터삽입", 'href'=>$tablename."/new", 'class'=>"btn btn-primary btn-sm", 'role'=>"button"]);
        $body = str_replace("{{btnInsert}}",$btnInsert, $body); 
        
 
        return $body;
    }


    /**
     * 데이터 삽입
     */
    public function new($tablename)
    {
        if ($this->http->method() == "POST") {
            return $this->create_action($tablename);
        } else {
            // 새로운 컬럼
            return $this->create_view($tablename);
        }
    }

    private function create_view($tablename)
    {
        
        $rows = $this->db->table($tablename)->desc();

        // htmlform 빌더
        $form = \jiny\factory("\Jiny\Html\Form");
        $form->setMethod("POST");

        foreach($rows as $row) {
            if($row['Field'] == "id") continue;
            if($row['Field'] == "created_at") continue;
            if($row['Field'] == "updated_at") continue;

            // 항목추가
            $content = \jiny\template("../Resource/view/forms/label_input_text.html.php",['name'=>$row['Field']]);
            $form->setField($content);
        }

        $btn_insert = $form->submit(['name'=>"add", 'value'=>"삽입", 'class'=>"btn btn-primary btn-sm"]);
        $form->setField($btn_insert);


        $body = file_get_contents("../Resource/view/insert.html");
        $body = str_replace("{{content}}",$form->build(), $body); // 데이터 치환
        return $body;
    }



    private function create_action($tablename)
    {
        // 쿼리 생성
        if ($_POST) {
            $fields = " (";
            $data = "(";
            foreach ($_POST['postdata'] as $key => $value) {
                $fields .= "`".$key."`,";
                $data .= "'".$value."',";
            }

            $fields = rtrim($fields,","); // 마지막 콤마 제거
            $data = rtrim($data,","); // 마지막 콤마 제거
            $fields .= ")";
            $data .= ")";
  
            $query = "INSERT INTO ".$tablename . $fields . " VALUES ".$data; 
            $this->db->query($query);
            
            // 페이지 이동
            header("location:"."/select/".$tablename);
        }
    }



    /**
     * 데이터수정
     */
    public function edit($tablename, $id)
    {
        if ($this->http->method() == "POST") {           
            if($_POST['mode']=="edit") {
                return $this->edit_action($tablename, $id);
            } else if($_POST['mode']=="delete"){             
                return $this->delete($tablename, $id);
            }
        } else {
            // 새로운 컬럼
            return $this->edit_view($tablename, $id);
        }
    }

    public function edit_view($tablename, $id)
    {
        // 데이터 조회
        $query = "SELECT * from ".$tablename." WHERE id = ".$id;
        $this->db->query($query);
        if ($data = $this->db->fetchAssoc()) {

            $markup = \jiny\htmlMarkup(); //html Markup builder

            // 수정폼 생성
            // htmlform 빌더
            $form = \jiny\factory("\Jiny\Html\Form");
            $form->setMethod("POST");

            $hidden = "<input type=\"hidden\" name=\"id\" value='$id'>";
            $form->setField(["id"=> $hidden]);

            $hidden_mode = "<input type=\"hidden\" name=\"mode\" value='edit'>";
            $form->setField(["mode"=> $hidden_mode]);

            $rows = $this->db->table($tablename)->desc();
            foreach($rows as $row) {
                if($row['Field'] == "id") continue;
                if($row['Field'] == "created_at") continue;
            if($row['Field'] == "updated_at") continue;

                // 항목추가               
                $content = \jiny\template("../Resource/view/forms/label_input_text.html.php",
                    ['name'=>$row['Field'],
                    'value'=>$data[ $row['Field'] ]
                    ]);
                
                $form->setField([$row['Field'] => $content]);

            }

            // 확인버튼
            $btn_submit = $form->submit(['value'=>"수정", 'class'=>"btn btn-primary btn-sm"]);
            $form->setField(["submit" => $btn_submit]);

            // 삭제버튼
            $btn_delete = $form->button(['name'=>"delete", 'value'=>"삭제", 'class'=>"btn btn-danger btn-sm", 
                'id'=>"delete", 'onclick'=>"btn_delete();"]);
            $markup->script()->btn_delete();            
            $form->setField(["delete"=> $btn_delete]);

            // 폼을 생성합니다. 폼+자바스크립트
            $formbody = $form->build().$markup->script()->build();

        } else {
            echo "데이터가 존재하지 않습니다.";
        }
      
        $body = file_get_contents("../Resource/view/edit.html");
        $body = str_replace("{{content}}", $formbody, $body); // 데이터 치환

        return $body;
    }




    public function edit_action($tablename, $id)
    {
        if ($_POST) {
            //print_r($_POST);
            // exit;

            $query = "UPDATE ".$tablename." SET ";
            // 갱신 데이터
            foreach ($_POST['postdata'] as $key => $value) {
                $query .= "`$key`= '".$value."',";
            }
            
            $query = rtrim($query, ","); // 마지막 콤마 제거

            // 조건값
            $query .= " WHERE id='".$id."'";
            // echo $query;
            // exit;

            $result = $this->db->query($query);

            // 페이지 이동
            header("location:"."/select/".$tablename);

        }
    }

    /**
     * 데이터 삭제
     */
    private function delete($tablename, $id)
    {
        
        $query = "DELETE FROM ".$tablename." "; // 삭제쿼리
        $query .= "WHERE id='".$id."'"; // 조건
        echo $query; // 쿼리 확인 습관.

        $result = $this->db->query($query);

        // 페이지 이동
        header("location:"."/select/".$tablename);

    }

    /**
     * 
     */
}
