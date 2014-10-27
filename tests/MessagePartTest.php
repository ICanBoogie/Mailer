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

class MessagePartTest extends \PHPUnit_Framework_TestCase
{
	public function test_body()
	{
		$mp = new MessagePart('BODY');
		$this->assertEquals('BODY', $mp->body);

		$mp->body = 'BODY2';
		$this->assertEquals('BODY2', $mp->body);
	}
}
