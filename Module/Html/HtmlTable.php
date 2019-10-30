<?php
namespace Module\Html;

class HtmlTable
{
    function table($rows)
    {
        $body = "<table class=\"table\">";
        $body .= "<thead>";
        /*
        $body .= "<tr>
            <th>번호</th>
            <th>테이블명</th>
        </tr>";
        */
        $body .= "<tr>";
        foreach ($rows[0] as $key => $value) {
            $body .= "<th>".$key."</th>";
        }
        $body .= "</tr>";

        $body .= "</thead>";
        $body .= "<tbody>";
        
        // https://github.com/infohojin/php_www
        // 2차원 배열, 이중 반복문...
        // for = 상위배열.
        for($i=0;$i<count($rows);$i++) {
            $body .= "<tr>";
            // $body .= "<td>$i</td>";
            // $body .= "<td><a href='/TableInfo/".$rows[$i]->Tables_in_php."'>".$rows[$i]->Tables_in_php."</a></td>";
            // 하위배열
            // 키, 값 연상배열 형태로 풀어서 작업함.
            foreach ($rows[$i] as $key => $value) {
                $body .= "<td>".$value."</td>";
            }
            
            $body .= "</tr>";
        }    

        $body .= "</tbody>";
        $body .= "</table>";
        return $body;
    }
}
