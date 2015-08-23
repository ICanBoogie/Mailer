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

use ICanBoogie\Mailer\AddressListTest\AddressListExtended;

class AddressListTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_encode_display_name
	 *
	 * @param string $display_name
	 * @param string $expected
	 */
	public function test_encode_display_name($display_name, $expected)
	{
		$this->assertEquals($expected, AddressList::escape_display_name($display_name));
	}

	public function provide_test_encode_display_name()
	{
		return [

			[ 'Joe Q. Public', '"Joe Q. Public"' ],
			[ 'Mary Smith', 'Mary Smith' ],
			[ 'Who?', 'Who?' ],
			[ 'Giant; "Big" Box', '"Giant; \"Big\" Box"' ],
			[ 'ACME, Inc.', '"ACME, Inc."' ]

		];
	}

	public function test_get_iterator()
	{
		$r = new AddressList;
		$this->assertInstanceOf('ArrayIterator', $r->getIterator());
	}

	public function test_add_email()
	{
		$r = new AddressList;
		$r[] = 'olivier.laviale@gmail.com';

		$this->assertNotEmpty($r['olivier.laviale@gmail.com']);
	}

	public function test_set_email()
	{
		$r = new AddressList;
		$r['olivier.laviale@gmail.com'] = true;

		$this->assertNotEmpty($r['olivier.laviale@gmail.com']);
	}

	public function test_set_email_with_name()
	{
		$r = new AddressList;
		$r['olivier.laviale@gmail.com'] = 'Olivier Laviale';

		$this->assertNotEmpty($r['olivier.laviale@gmail.com']);
		$this->assertEquals('Olivier Laviale', $r['olivier.laviale@gmail.com']);
	}

	public function test_unset()
	{
		$r = new AddressList;
		$r[] = 'olivier.laviale@gmail.com';

		unset($r['olivier.laviale@gmail.com']);

		$this->assertFalse(isset($r['olivier.laviale@gmail.com']));
	}

	public function test_from_array()
	{
		$r = AddressList::from([

			'person1@example.com',
			'person2@example.org',
			'person3@example.net' => 'Person 3 Name',
			'person4@example.org',
			'person5@example.net' => 'Person 5 Name'

		]);

		$this->assertTrue($r['person1@example.com']);
		$this->assertTrue($r['person2@example.org']);
		$this->assertEquals('Person 3 Name', $r['person3@example.net']);
		$this->assertTrue($r['person4@example.org']);
		$this->assertEquals('Person 5 Name', $r['person5@example.net']);
	}

	public function test_from_string()
	{
		$r = AddressList::from(<<<EOT
person1@example.com  ,
person2@example.org ,    Person 3 Name <person3@example.net>, person4@example.org,
Pérsôn 5 Name <person5@example.net>
EOT
		);

		$this->assertTrue($r['person1@example.com']);
		$this->assertTrue($r['person2@example.org']);
		$this->assertEquals('Person 3 Name', $r['person3@example.net']);
		$this->assertTrue($r['person4@example.org']);
		$this->assertEquals('Pérsôn 5 Name', $r['person5@example.net']);
	}

	/*
	 * Make sure that AddressList::from() returns a `ICanBoogie\Mailer\AddressList` even when the
	 * source is a subclass of `AddressList`.
	 */
	public function test_from_extended()
	{
		$e = AddressListExtended::from('person@example.com');

		$this->assertInstanceOf('ICanBoogie\Mailer\AddressListTest\AddressListExtended', $e);
		$this->assertInstanceOf('ICanBoogie\Mailer\AddressList', AddressList::from($e));
	}

	public function test_to_string()
	{
		$r = new AddressList([

			'person1@example.com',
			'person2@example.org',
			'person3@example.net' => 'Person 3 Name',
			'person4@example.org',
			'person5@example.net' => 'Pérsôn 5 Nàmè'

		]);

		$this->assertEquals('person1@example.com, person2@example.org, Person 3 Name <person3@example.net>, person4@example.org, Pérsôn 5 Nàmè <person5@example.net>', (string) $r);
	}
}
