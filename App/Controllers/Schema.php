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

class Schema extends Controller
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
        // 데이터베이스에스에서 스키마 목록을 읽어 옵니다.
        $rows = $this->db->schema()->list(false);

        $layout = file_get_contents("../resource/view/layout.html");

            $content = file_get_contents("../resource/view/schema.html");
            $content = str_replace("{{content}}", $this->content($rows), $content);

        $layout = str_replace("{{content}}", $content, $layout);
        
        return $layout;
    }


    private function content($rows)
    {
        // 테이블 출력
        $content = "<table class='table'>";
        $content .= "<thead><tr>";
        $content .= "<th>스키마명</th>";
        $content .= "<th>테이블갯수</th>";
        $content .= "</tr></thead>";
        
        $content .= "<tbody>";
        foreach ($rows as $row) {
            foreach ($row as $key => $value)
            {
                // 두번째 인자로 스키마명 연결.
                $content .= "<tr>";
                $content .= "<td><a href='/schema/$value'>".$value."</a></td>";

                $query = "SELECT count(*) AS TOTALTABLES FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$value."';";
                $num = $this->db->query($query)->fetchAssoc();

                $content .= "<td><a href='/tables/$value'>".$num['TOTALTABLES']."</a></td>";
                $content .= "</tr>";
            }
        }
        $content .= "</tbody>";
        $content .= "</table>";
        return $content;
    }


    // 스키마처리
    public function __call($method, $params)
    {
        // echo "정의되지 않은 매소드";
        return $this->update($method, $params);
    }

    public function update($schema, $params)
    {
        // return $schema."";
        $layout = file_get_contents("../resource/view/layout.html");

            $content = file_get_contents("../resource/view/schema_update.html");
            $content = str_replace("{{content}}", $schema, $content);

        $layout = str_replace("{{content}}", $content, $layout);
        
        return $layout;
    }

    /**
     * 
     */
}