<?php
namespace Module\Html;

class HtmlTable
{
    function table($rows)
    {
        $body = "<table class=\"table\">";
        $body .= "<thead>";
        $body .= "<tr>
            <th>번호</th>
            <th>테이블명</th>
        </tr>";
        $body .= "</thead>";
        $body .= "<tbody>";
        
        // https://github.com/infohojin/php_www

        for($i=0;$i<count($rows);$i++) {
            $body .= "<tr>";
            $body .= "<td>$i</td>";
            $body .= "<td>".$rows[$i]->Tables_in_php."</td>";
            $body .= "</tr>";
        }    

        $body .= "</tbody>";
        $body .= "</table>";
        return $body;
    }
}
