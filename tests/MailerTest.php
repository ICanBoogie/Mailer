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

use ICanBoogie\Mailer\MailerTest\FakeDeliverer;

class MailerTest extends \PHPUnit_Framework_TestCase
{
	public function test_deliverer()
	{
		$deliverer = new FakeDeliverer;
		$mailer = new Mailer($deliverer);
		$message = new Message([

			'subject' => "Ûn süjét bièn chôsî",
			'body' => "Côrps dü méssàgè",
			'to' => "Ôlïvîèr Làvïàlé <person@host.com>",
			'bcc' => 'person@host.com',
			'from' => 'Nô Réplÿ <no-reply@localhost.com>'

		]);

		$mailer($message);

		$this->assertSame($message, $deliverer->message);
	}
}
