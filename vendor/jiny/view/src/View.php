<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Jiny\View;

class View
{
    /**
     * 싱글턴
     */
    private static $_instance;
    public static function instance($args=null)
    {
        if (!isset(self::$_instance)) {               
            self::$_instance = new self($args); // 인스턴스 생성
        } 
        return self::$_instance; 
    }

}

