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
 * An address list.
 *
 * <pre>
 * <?php
 *
 * use ICanBoogie\Mailer\AddressList;
 *
 * $list = new AddressList;
 * $list[] = "olivier.laviale@gmail.com";
 * # or
 * $list["olivier.laviale@gmail.com"] = true;
 * # or, with a name
 * $list["olivier.laviale@gmail.com"] = "Olivier Laviale";
 *
 * # Creating a collection from an array
 *
 * $list = new AddressList([
 *
 *     'person1@example.com',
 *     'person2@example.org',
 *     'person3@example.net' => 'Person 3 Name',
 *     'person4@example.org',
 *     'person5@example.net' => 'Person 5 Name'
 *
 * ]);
 *
 * isset($list['person1@example.com']); // true
 * # remove mailbox
 * unset($list['person1@example.com']);
 * isset($list['person1@example.com']); // false
 * </pre>
 *
 * @see http://tools.ietf.org/html/rfc5322#section-3.4
 */
class AddressList implements \ArrayAccess, \IteratorAggregate
{
	/**
	 * Creates a {@link AddressList} instance from the provided source.
	 *
	 * @param string|array|AddressList $address_list The address list can be specified as a string,
	 * an array or an {@link AddressList} instance.
	 *
	 * While specified as a string, the address list must be separated by a comma. The display-name of
	 * the address can be defined using the following notation : "display-name <email>", where
	 * `display-name` is the name of the recipient and `email` is its email address.
	 *
	 * @return \ICanBoogie\Mailer\AddressList
	 *
	 * @see http://tools.ietf.org/html/rfc5322#section-3.4
	 */
	static public function from($address_list)
	{
		if (!$address_list)
		{
			return new static();
		}

		if ($address_list instanceof self)
		{
			return new static($address_list->address_list);
		}

		if (!is_array($address_list))
		{
			$address_list = static::parse($address_list);
		}

		return new static($address_list);
	}

	/**
	 * Parses an address-list string and returns an array of mailbox/display-name pairs.
	 *
	 * @param string $address_list
	 *
	 * @return array[string]string An array where each key/value pair represents a mailbox
	 * and a display-name, or an integer and a mailbox.
	 */
	static public function parse($address_list)
	{
		$parts = explode(',', $address_list);
		$parts = array_map('trim', $parts);

		$list = array();

		foreach ($parts as $part)
		{
			if ($part[strlen($part) - 1] === '>')
			{
				list($display_name, $angle_addr) = explode('<', $part, 2);

				$mailbox = substr($angle_addr, 0, -1);

				$list[$mailbox] = trim($display_name);

				continue;
			}

			$list[] = $part;
		}

		return $list;
	}

	/**
	 * Escapes the specified display name according to the specification.
	 *
	 * <pre>
	 * <?php
	 *
	 * use ICanBoogie\Mailer\AddressList;
	 *
	 * echo AddressList('Joe Q. Public');    // "Joe Q. Public"
	 * echo AddressList('Mary Smith');       // Mary Smith
	 * echo AddressList('Who?');             // Who?
	 * echo AddressList('Giant; "Big" Box'); // "Giant; \"Big\" Box"
	 * echo AddressList('ACME, Inc.');       // "ACME, Inc."
	 * </pre>
	 *
	 * @param string $display_name The display name to escape.
	 *
	 * @return string
	 *
	 * @see http://tools.ietf.org/html/rfc5322#section-3.2.3
	 * @see http://tools.ietf.org/html/rfc5322#appendix-A.1.2
	 */
	static public function escape_display_name($display_name)
	{
		if (preg_match('#\(|\)|\<|\>|\[|\]|\:|\;|\@|\\|\,|\.|\"#', $display_name))
		{
			$display_name = '"' . addslashes($display_name) . '"';
		}

		return $display_name;
	}

	/**
	 * A collection of recipient.
	 *
	 * Each key/value pair represents a mailbox and a display-name, which might be `true` if
	 * the display-name of mailbox was not provided.
	 *
	 * @var array
	 */
	protected $address_list = array();

	/**
	 * Initializes the {@link $address_list} property.
	 *
	 * Note: The method uses the `ArrayAccess` interface to set the mailboxes.
	 *
	 * @param array $address_list An address list, such as one provided by
	 * the {@link parse()} method.
	 */
	public function __construct(array $address_list = array())
	{
		foreach ($address_list as $mailbox => $display_name)
		{
			if (is_numeric($mailbox))
			{
				$this[] = $display_name;

				continue;
			}

			$this[$mailbox] = $display_name;
		}
	}

	/**
	 * Checks if the recipient exists in the collection.
	 *
	 * @param string $mailbox
	 *
	 * @return bool `true` if the recipient exists, `false` otherwise.
	 */
	public function offsetExists($mailbox)
	{
		return isset($this->address_list[$mailbox]);
	}

	/**
	 * Adds or sets a recipient.
	 *
	 * @param string $mailbox
	 * @param string $display_name
	 *
	 * @throws \InvalidArgumentException when `$mailbox` is not a valid email address.
	 */
	public function offsetSet($mailbox, $display_name)
	{
		if ($mailbox === null)
		{
			$mailbox = $display_name;
			$display_name = true;
		}

		if (!filter_var($mailbox, FILTER_VALIDATE_EMAIL))
		{
			throw new \InvalidArgumentException("Invalid email address: $mailbox.");
		}

		$this->address_list[$mailbox] = $display_name;
	}

	/**
	 * Returns the recipient name.
	 *
	 * @param string $mailbox The email of the recipient.
	 *
	 * @return string
	 */
	public function offsetGet($mailbox)
	{
		return $this->address_list[$mailbox];
	}

	/**
	 * Removes a recipient.
	 *
	 * @param string $mailbox The email of the recipient.
	 */
	public function offsetUnset($mailbox)
	{
		unset($this->address_list[$mailbox]);
	}

	/**
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->address_list);
	}

	/**
	 * Returns a string representation of the instance.
	 *
	 * Note: The returned string is not suitable for a header field,
	 * use a {@link Header\AddressList} instance for that.
	 *
	 * @return string An address-list string that can be parsed by
	 * the {@link parse()} method.
	 */
	public function __toString()
	{
		$rc = '';

		foreach ($this->address_list as $mailbox => $display_name)
		{
			if ($rc)
			{
				$rc .= ', ';
			}

			if ($display_name === true)
			{
				$rc .= $mailbox;

				continue;
			}

			$rc .= static::escape_display_name($display_name) . " <$mailbox>";
		}

		return $rc;
	}
}
