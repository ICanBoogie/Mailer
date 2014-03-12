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

class FileDelivererTest extends \PHPUnit_Framework_TestCase
{
	public function test_deliver()
	{
		$message = new Message([

			'subject' => "Ûn süjét bièn chôsî",
			'body' => "Côrps dü méssàgè",
			'to' => "Ôlïvîèr Làvïàlé <person@host.com>, person2@host.com",
			'bcc' => 'person@host.com',
			'from' => 'Nô Réplÿ <no-reply@localhost.com>'

		]);

		$delivery = new FileDeliverer(REPOSITORY);
		$delivery->deliver($message);

		$this->assertFileExists(REPOSITORY . DIRECTORY_SEPARATOR . 'person@host.com');
		$this->assertFileExists(REPOSITORY . DIRECTORY_SEPARATOR . 'person2@host.com');
	}
}