<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Mailer\MailerTest;

use ICanBoogie\Mailer\Deliverer;
use ICanBoogie\Mailer\Message;

class FakeDeliverer implements Deliverer
{
	public $message;

	public function deliver(Message $message)
	{
		$this->message = $message;
	}
}
