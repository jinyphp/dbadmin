<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace jiny;

 if (!function_exists("template")) {
    function template($file, $vars=[]) :string
    {
        extract($vars); // 키명으로 변수화
        ob_start(); // 출력 버퍼링
        include($file);
        return ob_get_clean(); // 버퍼를 반환합니다.
    }
}