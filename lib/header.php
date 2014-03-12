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

/**
 * Representation of header fields.
 *
 * @see http://tools.ietf.org/html/rfc5322#section-2.2
 */
class Header implements \ArrayAccess, \IteratorAggregate
{
	static private $mapping = [

		'Content-Type'        => 'ICanBoogie\Mailer\ContentTypeHeader',
		'From'                => 'ICanBoogie\Mailer\FromHeader',
		'Reply-To'            => 'ICanBoogie\Mailer\ReplyToHeader',
		'To'                  => 'ICanBoogie\Mailer\ToHeader',
		'Cc'                  => 'ICanBoogie\Mailer\CcHeader',
		'Bcc'                 => 'ICanBoogie\Mailer\BccHeader',

	];

	/**
	 * Header fields.
	 *
	 * @var array[string]mixed
	 */
	protected $fields = [];

	public function __construct(array $fields=[])
	{
		foreach ($fields as $field => $value)
		{
			$this[$field] = $value;
		}
	}

	public function __clone()
	{
		foreach ($this->fields as $field => $value)
		{
			$this->fields[$field] = clone $value;
		}
	}

	/**
	 * Returns the string representation of the instance.
	 *
	 * Header fields with empty string values are discarted.
	 *
	 * @return string
	 */
	public function __toString()
	{
		$header = '';

		foreach ($this->fields as $field => $value)
		{
			$value = (string) $value;

			if ($value === '')
			{
				continue;
			}

			$header .= "$field: $value\r\n";
		}

		return $header;
	}

	/**
	 * Checks if a header field exists.
	 *
	 * @param mixed $field
	 *
	 * @return boolean
	 */
	public function offsetExists($field)
	{
		return isset($this->fields[(string) $field]);
	}

	/**
	 * Returns a header.
	 *
	 * @param mixed $field
	 *
	 * @return string|null The header field value or null if it is not defined.
	 */
	public function offsetGet($field)
	{
		if (isset(self::$mapping[$field]) && empty($this->fields[$field]))
		{
			$class = self::$mapping[$field];
			$this->fields[$field] = $class::from(null);
		}

		return $this->offsetExists($field) ? $this->fields[$field] : null;
	}

	/**
	 * Sets a header field.
	 *
	 * Note: Setting a header field to `null` removes it, just like unset() would.
	 *
	 * @param string $field The header field to set.
	 * @param mixed $value The value of the header field.
	 */
	public function offsetSet($field, $value)
	{
		if ($value === null)
		{
			unset($this[$field]);

			return;
		}

		if (isset(self::$mapping[$field]))
		{
			$value = call_user_func(self::$mapping[$field] . '::from', $value);
		}

		$this->fields[$field] = $value;
	}

	/**
	 * Removes a header field.
	 */
	public function offsetUnset($field)
	{
		unset($this->fields[$field]);
	}

	/**
	 * Returns an iterator for the header fields.
	 */
	public function getIterator()
	{
		// TODO: sort fields

		return new \ArrayIterator($this->fields);
	}
}