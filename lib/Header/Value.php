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

class Value
{
	protected $value;

	static public function from($value)
	{
		return new static($value);
	}

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function __toString()
	{
		$value = $this->value;
		$charset = mb_detect_encoding($value);

		if ($charset != 'ASCII')
		{
			$value = mb_convert_encoding($value, 'UTF-8');
			$value = mb_encode_mimeheader($value);
		}

		return $value;
	}
}
