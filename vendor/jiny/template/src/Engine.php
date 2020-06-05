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

class Engine
{
    private $_engine;

    /**
     * 템플릿 엔진을 확인합니다.
     */
    public function isEngine()
    {
        return "Liquid";
    }

    /**
     * 템플릿 엔진을 설정합니다.
     */
    public function setEngine($engine)
    {
        $this->_engine = $engine;
    }

    /**
     * 
     */
}