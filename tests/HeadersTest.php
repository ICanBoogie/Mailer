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

class HeaderTest extends \PHPUnit_Framework_TestCase
{
	static private $header;
	static private $email = 'person@example.com';

	static public function setupBeforeClass()
	{
		self::$header = new Header;
	}

	public function test_get_from()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['From']);
		$this->assertInstanceOf('ICanBoogie\Mailer\FromHeader', self::$header['From']);
	}

	public function test_set_from()
	{
		self::$header['From'] = self::$email;

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['From']);
		$this->assertInstanceOf('ICanBoogie\Mailer\FromHeader', self::$header['From']);
		$this->assertEquals(self::$email, (string) self::$header['From']);
	}

	public function test_get_to()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['To']);
		$this->assertInstanceOf('ICanBoogie\Mailer\ToHeader', self::$header['To']);
	}

	public function test_set_to()
	{
		self::$header['To'] = self::$email;

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['To']);
		$this->assertInstanceOf('ICanBoogie\Mailer\ToHeader', self::$header['To']);

		$this->assertEquals(self::$email, (string) self::$header['To']);
	}

	public function test_get_cc()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['Cc']);
		$this->assertInstanceOf('ICanBoogie\Mailer\CcHeader', self::$header['Cc']);
	}

	public function test_set_cc()
	{
		self::$header['Cc'] = self::$email;

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['Cc']);
		$this->assertInstanceOf('ICanBoogie\Mailer\CcHeader', self::$header['Cc']);

		$this->assertEquals(self::$email, (string) self::$header['Cc']);
	}

	public function test_get_bcc()
	{
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['Bcc']);
		$this->assertInstanceOf('ICanBoogie\Mailer\BccHeader', self::$header['Bcc']);
	}

	public function test_set_bcc()
	{
		self::$header['Bcc'] = self::$email;

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', self::$header['Bcc']);
		$this->assertInstanceOf('ICanBoogie\Mailer\BccHeader', self::$header['Bcc']);

		$this->assertEquals(self::$email, (string) self::$header['Bcc']);
	}

	public function test_to_string()
	{
		$h = new Header([

			'To' => 'Ôlïvîèr Làvïâlé <olivier.laviale@gmail.com>',
			'Bcc' => 'madona@gmail.com'

		]);

		$this->assertEquals
		(
			<<<EOT
To: =?UTF-8?B?w5Rsw692w67DqHIgTMOgdsOvw6Jsw6k=?= <olivier.laviale@gmail.com>\r\nBcc: madona@gmail.com\r\n
EOT

			, (string) $h
		);
	}
}