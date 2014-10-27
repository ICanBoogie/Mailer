<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Mailer\Header;

class ContentType
{
	public $type = 'text/plain';
	public $charset = 'UTF-8';

	static public function from()
	{
		return new static;
	}

	public function __toString()
	{
		return "{$this->type}; charset={$this->charset}";
	}
}
