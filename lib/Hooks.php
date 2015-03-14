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

use ICanBoogie\Core;

class Hooks
{
	/**
	 * Returns a {@link Mailer} instance.
	 *
	 * @param Core $app
	 *
	 * @return \ICanBoogie\Mailer\Mailer
	 */
	static public function core_lazy_get_mailer(Core $app)
	{
		return new Mailer;
	}

	/**
	 * Send the message using the mailer available at `$app->mailer`.
	 *
	 * @param Core $app
	 * @param array|Message $message A message source suitable for {@link Message::from()}.
	 * @param array $options
	 *
	 * @return mixed
	 */
	static public function core_mail(Core $app, $message, array $options = [])
	{
		$options += [

			'sender' => null

		];

		/* @var $mailer Mailer */

		$mailer = $app->mailer;
		$message = Message::from($message);
		$sender = $options['sender'];

		if ($sender && class_exists('ICanBoogie\Event'))
		{
			new BeforeMailEvent($sender, $message, $mailer);
		}

		$rc = $mailer($message);

		if ($sender && class_exists('ICanBoogie\Event'))
		{
			new MailEvent($sender, $rc, $message, $mailer);
		}

		return $rc;
	}
}
