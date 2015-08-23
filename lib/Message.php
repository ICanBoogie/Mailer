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
 * Representation of a message.
 *
 * <pre>
 * <?php
 *
 * use ICanBoogie\Mailer\Message;
 *
 * $message = new Message;
 *
 * # to, cc, bcc
 * $message->to = "person@domain.com";
 * # or
 * $message->to = "Person name <person@domain.com>";
 * # or
 * $message->to = [ "person@domain.com" => "Person name" ];
 *
 * # multiple recipients
 * $message->to = [ "person@domain.com" => "Person name", "person2@domain.com" ];
 * # or
 * $message->to = "Person name<person@domain.com>, person2@domain.com";
 * </pre>
 *
 * @property Header\From $from
 * @property Header\To $to Representation of the `To` header field.
 * @property Header\Cc $cc Representation of the `Cc` header field.
 * @property Header\Bcc $bcc Representation of the `Bcc` header field.
 * @property-write string $type The message type, either "html" or "plain".
 */
class Message extends MessagePart
{
	static $property_to_header = [

		'from' => 'From',
		'to'   => 'To',
		'cc'   => 'Cc',
		'bcc'  => 'Bcc'

	];

	static public function from($source)
	{
		if ($source instanceof self)
		{
			return $source;
		}

		if (!is_array($source))
		{
			throw new \InvalidArgumentException("\$source must either be a Message instance or an array.");
		}

		$header_fields = [];

		if (isset($source['header']))
		{
			// TODO-20140312: $source['header'] might be a string

			$header_fields = $source['header'];

			unset($source['header']);
		}

		return new static($source, $header_fields);
	}

	/**
	 * Subject of the message.
	 *
	 * @var string
	 */
	public $subject;

	protected $parts;
	protected $attachments;

	public function __construct(array $attributes=[], array $header_fields=[])
	{
		$body = isset($attributes['body']) ? $attributes['body'] : '';

		parent::__construct($body, $header_fields + [ 'Content-Type' => 'text/plain; charset=UTF-8' ]);

		foreach ($attributes as $attribute => $value)
		{
			switch ($attribute)
			{
				case 'bcc':
				case 'cc':
				case 'from':
				case 'subject':
				case 'type':
				case 'to':

					$this->$attribute = $value;

					break;

				case 'body':
					break;

				default:

					throw new PropertyNotDefined([ $attribute, $this ]);
			}
		}
	}

	public function __get($property)
	{
		switch ($property)
		{
			case 'bcc':
			case 'cc':
			case 'from':
			case 'to':

				return $this->header[self::$property_to_header[$property]];
		}

		return parent::__get($property);
	}

	public function __set($property, $value)
	{
		switch ($property)
		{
			case 'bcc':
			case 'cc':
			case 'from':
			case 'to':

				$this->header[self::$property_to_header[$property]] = $value;

				return;

			case 'type':

				$this->header['Content-Type']->type = "text/{$value}";

				return;
		}

		parent::__set($property, $value);
	}

	public function __toString()
	{
		return (string) $this->body;
	}

	/**
	 * @return array The prepared information for the mailer:
	 * - 0: (string) $to
	 * - 1: (string) $subject
	 * - 2: (string) $body
	 * - 3: (string) $header
	 */
	public function prepare()
	{
		$subject = (string) $this->subject;
		$charset = mb_detect_encoding($subject);

		if ($charset != 'ASCII')
		{
			$subject = mb_convert_encoding($subject, 'UTF-8');
			$subject = mb_encode_mimeheader($subject, 'UTF-8');
		}

		$header = clone $this->header;

		unset($header['To']);
		unset($header['Subject']);

		return [ (string) $this->to, $subject, (string) $this, (string) $header ];
	}
}
