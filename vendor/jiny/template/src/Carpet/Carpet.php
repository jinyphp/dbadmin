<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Template\Carpet;

use \Jiny\Core\Registry\Registry;
/**
 * 카펫(carpet) 템플릿
 */
class Carpet
{
    const PREFIX_START = "{(";
    const PREFIX_END = ")}";

    /**
     * 
     */
    public function __construct()
    {
        //echo "카페트 엔진 적용<br>";
        $this->setPreStart(self::PREFIX_START);
        $this->setPreEnd(self::PREFIX_END);
    }

    /**
     * 
     */
    public function parser($body)
    {
        if($codes = $this->preFixs($body)){
            return $this->render($codes, $body);
        } else {
            return $body;
        }        
    }

    /**
     * 
     */
    public function render($codes, $body)
    {
        foreach ($codes as $value) {
            //echo "<pre>";
            //print_r($data = $this->conf->data());
            //echo "</pre>";
            switch ($value[0]) {
                case '#':                    
                    $body = $this->renderValue($value, $body);                    
                    break;
                case '$':
                
            }
            

        }

        return $body;
    }


    /**
     * 값을 처리합니다.
     */
    public function renderValue($value, $body)
    {
        /*
        // 환경변수의 값을 출력합니다.
        $key = substr($value, 1);
        // echo $key."<br>";
        if ($data = $this->conf->data($key)) {
            //print_r($data);
            $body = str_replace(
                self::PREFIX_START." ".$value." ".self::PREFIX_END, 
                $data, 
                $body);
        } else {
            $body = str_replace(
                self::PREFIX_START." ".$value." ".self::PREFIX_END, 
                "", 
                $body);
        }
        */

        return $body;
    }


    protected $_prefixStart;
    protected $_prefixEnd;
    
    public function setPreStart($start)
    {
        $this->_prefixStart= $start;
        return $this;
    }

    public function setPreEnd($end)
    {
        $this->_prefixEnd= $end;
        return $this;
    }


    // prefix 코드를 배열로 가지고 옵니다.
    public function preFixs($body)
    {
        // prefix가 몇개가 있는지 갯수를 확인합니다.
        $count = substr_count($body, $this->_prefixStart);  
        $body_size = strlen($body);
        
        // prefix 마지막 체크
        $endfix = $this->_prefixEnd;
        $end_count = strlen($endfix);

        $overflow = false;

        // $j = 배열의 갯수
        for($pos=0, $j=0, $i=0; $i<$count; $i++){

            // 문서내에서 처음 prex코드의 위치를 찾습니다.
            // 코드를 찾으면 pos 값이 변경생성 됩니다.
            $pos = strpos($body,$this->_prefixStart,$pos);
            if ($pos !== false) {
                
                // pos의 위치를 ENV_PREFIX_START 길이많큼 이동을 합니다.
                $pos += strlen($this->_prefixStart);

                $prefix_vars = "";
                $tmp = "";
                $q = 0;

                while(1){
                    // 문서의 끝까지 
                    // 종료 기호를 찾지 못했을때 자동탈출
                    if($pos>=$body_size) {
                        $overflow = true;
                        break;
                    }

                    // 종료코드 기호 체크합니다.
                    if ( $body[$pos] == $endfix[0]) {
                        // End 코드를 미리 읽어 봅니다.                       
                        for($q=0, $endFix = ""; $q<$end_count; $q++) $endFix .= $body[$pos+$q];
                        if($endFix == $this->_prefixEnd){
                            // End 코드가 일치하면 루푸를 탈출합니다.
                            break; 
                        } else {
                                // End 코드가 일치하지 않으면 
                            // prefix 내용을 복사하고 탈출합니다.
                            $prefix_vars .= $body[$pos];
                            $pos++;
                        }                        	                       	

                    } else {
                        // prefix 내용을 복사합니다.
                        $prefix_vars .= $body[$pos];
                        $pos++;
                    }

                }

                // 찾은 prefix를 배열로 저장합니다. 
                // parsing 오버플로우 코드는 저장하지 않습니다.
                if($prefix_vars && !$overflow){
                    $rows[$j] = trim($prefix_vars);
                    $j++;
                }

            }

        }

        // 배열을 반환합니다.
        return $rows;
    }

    /**
     * 
     */
}