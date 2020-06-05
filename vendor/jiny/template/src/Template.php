<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\Template;

use \Jiny\Core\Registry\Registry;

/**
 * jiny 
 * 템플릿 처리
 * Liquid, Blade, Carpet
 */
class Template Extends Engine
{
    private $View;
    private $App;
    public $Processor;

    private $_viewHtml;

    public function __construct($view=null)
    {
        // 의존성 주입
        // View 클래스의 인스턴스르 저장합니다.
        $this->View = Registry::get("View"); //$view;
        $this->App = Registry::get("App"); //$view->App;
    }

    /**
     * 템플릿 엔진을 처리합니다.
     */
    public function process($html)
    {
        // 템플릿 엔진에 따라서 동작을 처리합니다.
        switch ($this->isEngine()) {
            // Liquid 템플릿 엔진처리
            case 'Liquid':
                $this->Processor = new \Jiny\Template\Adapter\Liquid($this->View);    
                $html->_body = $this->Processor->Liquid($html->_body, $html->_data);
                break;

            default:
        }
    }



    /**
     * 
     */
}