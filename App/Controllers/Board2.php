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

class Board2 extends Controller
{
    private $db;
    private $endpoint;

    private $csrf;
    public function __construct()
    {
        // 데이터베이스
        $dbinfo = \jiny\dbinfo();
        $this->db = \jiny\factory("\Jiny\Mysql\Connection", $dbinfo);

        $this->endpoint = \jiny\endpoint();
        $this->csrf = "hello";
    }

    public function main($params=null)
    {
        // board parser
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "post 요청입니다.";
            if($second = $this->endpoint->second()) {
                if ($second == "new" && $_POST['mode'] == "newup") {
                    echo "새글작성-등록절차";
                }
            }            
        } else if($_SERVER["REQUEST_METHOD"] == "GET") {
            echo "get 요청입니다.";
            if($second = $this->endpoint->second()) {
                if(is_numeric($second)) {
                    return "계시물 선택".$second;
                } else if ($second == "new") {
                    
                }
                echo "없음".$second;
                exit;
            } else {
                // 리스트 목록
                return $this->list();
            }
            
        }
        
    }

    public function list()
    {
        $rows = $this->db->select("board",['id','title'])->runObjAll();
        // print_r($rows);
        // exit;
        // 데이터목록
        $body = "<table>";
        if ($rows) {
            
            foreach($rows as $row) {
                $body .= "<tr>";
                foreach($row as $key => $value) {
                    $body .= "<td><a href='".$row->id."'>". $value. "</a></td>";
                }
                $body .= "</tr>";
            }
            
        } else {
            $body .= "<tr><td>데이터목록이 없습니다.</td></tr>";
        }
        $body .= "</table>";

        return $body;
    }
    


    public function new()
    {
        // parser
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            

        } else {
            // 새글작성
            // $body = \file_get_contents("../resource/view/board_new.php.html");
            $file = "../resource/view/board_new.php.html";
           
            $csrf = \jiny\board\csrf($this->csrf);
            $body = \jiny\template($file, $vars=['csrf'=>$csrf]);
            return $body;
        }
    
    }



    public function edit($id=null)
    {
        // parser
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // 새글 등록 DB 작업
            if ($_POST['mode'] == "editup") {
                if (\jiny\board\isCsrf()) {
                    // 데이터삽입
                    print_r($_POST);
                    $update = $this->db->update("board")->setFields($_POST['data'])->id($_POST['data']['id']);
                    $url = "/".$this->endpoint->first()."/";
                } else {
                    return "csrf 불일치";
                }
            }

            // post redirect get pattern
            \jiny\board\redirect($url);

        } else {
            // return "글을 수정합니다.".$id;
            $file = "../resource/view/board_edit.php.html";
            
            $csrf = \jiny\board\csrf($this->csrf);
            // $data = ['title'=>"12345"];
            // $data = $this->db->select("board")->id(1);
            $fields = ["id","title"];
            $select = $this->db->select("board")->setFields($fields)->setWheres(["id"]);
            $select->build($fields);
            // echo $this->db->getQuery();
            $data = $select->run(['id'=>$id])->fetchObj();
            // print_r($data);
            // exit;


            $body = \jiny\template($file, $vars=['csrf'=>$csrf, 'data'=>$data ]);
            return $body;
        }
        
    }

    private function delete($id=null)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->db->delete("board")->id($id);

            // post redirect get pattern
            $url = "/".$this->endpoint->first()."/";
            \jiny\board\redirect($url);
        } else {
            return $id."를 삭제하시겠습니까?";
        }        
    }

    public function __call($method, $params)
    {
        if ( is_numeric($method) ) {
            $id = \intval($method);
            if($third = $this->endpoint->third()) {
                if($third == "edit") {
                    // 글 수정
                    return $this->edit($id);
                    // return "글수정".$method;
                } else if($third == "delete") {
                    // 글 삭제
                    // return "글삭제".$method;
                    return $this->delete($id);
                }
            } else {
                return $this->edit($method);
                return "글읽기".$method;
            }
        }     
    }

    /**
     * 
     */
}
