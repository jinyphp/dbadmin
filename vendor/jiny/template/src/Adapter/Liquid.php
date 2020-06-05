<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Template\Adapter;

use \Jiny\Core\Registry\Registry;
/**
 * 어뎁터 패턴
 * liquid/liquid 페키지로 결합합니다.
 */
class Liquid
{
    private $View;
    public $Liquid;

    /**
     * 
     */
    public function __construct($view=null)
    {
        // 의존성 주입
        // View 클래스의 인스턴스르 저장합니다.
        $this->View = $view;

        // 리소스 설정값을 변환하여, 인스턴스를 생성합니다.
        $path = $this->path();        
        $this->Liquid = $this->factory($path);

    }


    /**
     * 레이아웃 결합을 위한 기본 루트 경로를 설정합니다.
     */
    private function path()
    {
        $path = ROOTPATH.Registry::get("CONFIG")->data("ENV.path.pages");
        $path = str_replace("/", DS, $path);
        return $path;
    }


    /**
     * 인스턴스를 생성합니다.
     */
    private function factory($path)
    {
        \Liquid\Liquid::set('INCLUDE_ALLOW_EXT', true);

        // liquid 4.0
        // 테그변경
       
        \Liquid\Liquid::$config['TAG_START'] = "{%-";
        \Liquid\Liquid::$config['TAG_END'] = "-%}";

        \Liquid\Liquid::$config['VARIABLE_START'] = "{{-";
        \Liquid\Liquid::$config['VARIABLE_END'] = "-}}";
       

        // 인스턴스를 생성합니다.
        return new \Liquid\Template($path);
    }


    /**
     * Liquid 랜더링을 처리합니다.
     */
    public function Liquid($body, $data)
    {        
        // Liquid 코드를 추출합니다.
        $this->Liquid->parse($body);

        // 추출한 코드에 데이터를 처리합니다.
        return $this->Liquid->render($data);
    }

    /**
     * 
     */
}