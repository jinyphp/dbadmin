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

class Board1 extends Controller
{
    private $db;

    public function __construct()
    {
        // 데이터베이스
        $dbinfo = \jiny\dbinfo();
        $this->db = \jiny\factory("\Jiny\Mysql\Connection", $dbinfo);  
    }

    private $_tablename = "board";
    public function main($params=null)
    {
        return $this->read($this->_tablename);
    }

    public function read($tablename)
    {   
        $markup = \jiny\htmlMarkup(); //html Markup builder

        if ( $tablename ) {
            $crud = new \Jiny\Board\CRUD();
            $content = $crud->read($tablename);
        } else {
            $content = "데이터가 없습니다.";
        }            

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
    public function new()
    {
        $crud = new \Jiny\Board\CRUD();

        if ($this->http->method() == "POST") {
            //return $this->create_action($tablename);
            $crud->POST($this->_tablename);

        } else {

            $fields = [
                'name'=>[
                    'type'=>"input"
                ]
            ];


            // 새로운 컬럼
            // $form = $crud->create($this->_tablename);
            $create = new \Jiny\Board\Create();
            $form = $create->build($fields);

            $body = file_get_contents("../Resource/view/insert.html");
            $body = str_replace("{{content}}", $form, $body); // 데이터 치환
            return $body;
        }
    }


    public function __call($method, $params)
    {
        if ( is_numeric($method) ) {
            // 데이터 수정
            return $this->update($this->_tablename, $method);
        }     
    }



    /**
     * 데이터수정
     */
    public function update($tablename, $id)
    {
        $crud = new \Jiny\Board\CRUD();

        if ($this->http->method() == "POST") {           
            if($_POST['mode']=="edit") {
                return $this->edit_action($tablename, $id);

            } else if($_POST['mode']=="delete"){             
                $crud->delete($tablename, $id);
                header("location:"."/board"); // 페이지 이동

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
        echo $query;
        

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

            $rows = $this->db->tableDesc($tablename);
            foreach($rows as $row) {
                if($row['Field'] == "id") continue;

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
            /*
            $query = "UPDATE ".$tablename." SET ";
            // 갱신 데이터
            foreach ($_POST['postdata'] as $key => $value) {
                if($key == "id") continue;
                if($key == "created_at") continue;
                if($key == "updated_at") continue;

                $query .= "`$key`= '".$value."',";
            }
            
            $query = rtrim($query, ","); // 마지막 콤마 제거

            // 조건값
            $query .= " WHERE id='".$id."'";
      

            $result = $this->db->query($query);
            */

            $this->db->update($tablename)->setFields($_POST['postdata'])->id($id);

            // 페이지 이동
            header("location:"."/board");

        }
    }

    

    /**
     * 
     */
}
