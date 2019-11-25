<?php
namespace Module\Http;

// 선언 -> 생성 -> 호출
// 데이터베이스 선언
class Uri
{
    public $uri; // 외부접근 허용
    private $uris; // 내부만

    public function __construct()
    {
        // echo __CLASS__;
        // 쿼리스트링 부분,  분리함
        $uri = explode("?",$_SERVER['REQUEST_URI']);
        $this->uri= $uri[0]; // 실제 uri 부분만 저장

        $this->uris = explode("/",$this->uri); // 파란책
        unset($this->uris[0]); // 0번 배열은 제거
    }

    public function first()
    {
        if(isset($this->uris[1]) && $this->uris[1]) {
            return $this->uris[1];
        }
    }

    public function second()
    {
        if(isset($this->uris[2]) && $this->uris[2]) {
            return $this->uris[2];
        }
    }

    public function third()
    {
        if(isset($this->uris[3]) && $this->uris[3]) {
            return $this->uris[3];
        }
    }

    public function fourth()
    {
        if(isset($this->uris[4]) && $this->uris[4]) {
            return $this->uris[4];
        }
    }

}