<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jiny\Database;

/**
 * DB접속 환경파일을 읽어 옵니다.
 */
if (! function_exists('db_conf')) {
    function db_conf($filename) {
        if (file_exists($filename)) {
            return include $filename;
        } 
    }
}

/**
 * DB접속을 초기화 합니다.
 */
if (! function_exists('db_init')) {
    function db_init($dbconf) {
        if ($dbconf) {
            return new \Jiny\Database\Database($dbconf);
        } else {
            echo "DB 설정이 없습니다.";
            exit;
        }
    }
}


if (! function_exists('bindParams')) {
    function bindParams($stmt, $data)
    {
        foreach ($data as $field => &$value) {
            $stmt->bindParam(':'.$field, $value);
        }
        return $stmt;
    }
}

/**
 * 연상배열 여부 체크
 */
if (! function_exists('isAssoArray')) {
    function isAssoArray($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}


