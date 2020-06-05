<?php
/*
 * This file is part of the jinyPHP package.
 *
 * (c) hojinlee <infohojin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
// namespace Jiny\Template;

if (! function_exists('liquid')) {
    function liquid($body, $data = []) {
		$liquid = new \Jiny\Template\Adapter\Liquid;    
		return $liquid->Liquid($body, $data);
	}
}