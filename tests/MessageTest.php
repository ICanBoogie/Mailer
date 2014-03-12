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

class MessageTest extends \PHPUnit_Framework_TestCase
{
	static private $message;

	static public function setupBeforeClass()
	{
		self::$message = new Message;
	}

	public function test_get_to()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$message->to);
	}

	public function test_set_to()
	{
		self::$message->to = 'person1@host.com';

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$message->to);
		$this->assertTrue(self::$message->to['person1@host.com']);
	}

	public function test_get_cc()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$message->cc);
	}

	public function test_set_cc()
	{
		self::$message->cc = 'person2@host.com';

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$message->cc);
		$this->assertTrue(self::$message->cc['person2@host.com']);
	}

	public function test_get_bcc()
	{
		self::$message->bcc = 'person3@host.com';

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$message->bcc);
		$this->assertTrue(self::$message->bcc['person3@host.com']);
	}

	public function test_get_header()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\Header', self::$message->header);
	}
}