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
 * Message mailer.
 */
class Mailer implements Deliverer
{
	protected $deliverer;

	public function __construct($deliverer=null)
	{
		if (!$deliverer)
		{
			$deliverer = new MailDeliverer;
		}

		$this->deliverer = $deliverer;
	}

	public function __invoke(Message $message)
	{
		return $this->deliver($message);
	}

	public function deliver(Message $message)
	{
		return $this->deliverer->deliver($message, $this);
	}
}
