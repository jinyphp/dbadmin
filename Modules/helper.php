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

if (!function_exists("viewFile")) {
    function viewFile($file, $data=null)
    {
        $obj = \Modules\Views\View::instance();        
        return $obj->file($file, $data);
    }
}

if (!function_exists("view")) {
    function view()
    {
        $obj = \Modules\Views\View::instance();        
        return $obj;
    }
}

function callback($buffer)
{
  // return (str_replace("foo", "cool", $buffer));
  return (str_replace("<?=", "{{", $buffer));
}

function println($str)
{
    print $str;
    print "\n";
}




