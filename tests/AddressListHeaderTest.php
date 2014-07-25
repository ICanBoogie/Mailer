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

class AddressListHeaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_to_string
	 */
	public function test_to_string($from, $expected)
	{
		$h = AddressListHeader::from($from);
		$this->assertEquals($expected, (string) $h);
	}

	public function provide_test_to_string()
	{
		return [

			[ 'Ôlïvîèr Làvïâlé <olivier.laviale@gmail.com>', '=?UTF-8?B?w5Rsw692w67DqHIgTMOgdsOvw6Jsw6k=?= <olivier.laviale@gmail.com>' ],
			[ [ 'contact@example.com' => 'Joe Q. Public' ], '"Joe Q. Public" <contact@example.com>' ],
			[ [ 'contact@example.com' => 'Mary Smith' ], 'Mary Smith <contact@example.com>' ],
			[ [ 'contact@example.com' => 'Who?' ], 'Who? <contact@example.com>' ],
			[ [ 'contact@example.com' => 'Giant; "Big" Box' ], '"Giant; \"Big\" Box" <contact@example.com>' ],
			[ [ 'contact@acme.inc' => 'ACME, Inc.' ], '"ACME, Inc." <contact@acme.inc>' ],
			[ 'person1@example.com,person2@example.com', "person1@example.com,\r\n\tperson2@example.com" ]

		];
	}
}