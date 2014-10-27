<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Mailer;

use ICanBoogie\PropertyNotDefined;

/**
 * Representation of a message part.
 *
 * @property-read Header The {@link Header} of the message part.
 */
class MessagePart
{
	protected $header;
	public $body;

	public function __construct($body, array $header_fields=[])
	{
		$this->header = new Header($header_fields);
		$this->body = $body;
	}

	public function __clone()
	{
		$this->header = clone $this->header;
	}

	public function __get($property)
	{
		switch ($property)
		{
			case 'header':

				return $this->header;
		}

		throw new PropertyNotDefined([ $property, $this ]);
	}

	public function __set($property, $value)
	{
		throw new PropertyNotDefined([ $property, $this ]);
	}
}
