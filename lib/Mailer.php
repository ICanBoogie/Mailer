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
	/**
	 * @var Deliverer
	 */
	protected $deliverer;

	/**
	 * @param Deliverer|null $deliverer If `null` a {@link MailDeliverer} instance is created.
	 */
	public function __construct($deliverer = null)
	{
		if (!$deliverer)
		{
			$deliverer = new MailDeliverer;
		}

		$this->deliverer = $deliverer;
	}

	/**
	 * @param Message $message
	 *
	 * @return bool
	 *
	 * @see {@link deliver()}
	 */
	public function __invoke(Message $message)
	{
		return $this->deliver($message);
	}

	/**
	 * @inheritdoc
	 */
	public function deliver(Message $message)
	{
		return $this->deliverer->deliver($message, $this);
	}
}
