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
	 * @param Core $core
	 *
	 * @return \ICanBoogie\Mailer\Mailer
	 */
	static public function core_lazy_get_mailer(Core $core)
	{
		// TODO-20140312: Create instance with a "mailer" configuration.

		return new Mailer;
	}

	/**
	 * Send the message using the mailer available at `$core->mailer`.
	 *
	 * @param Core $core
	 *
	 * @param array|Message $message A message source suitable for {@link Message::from()}.
	 *
	 * @return mixed
	 */
	static public function core_mail(Core $core, $message)
	{
		$mailer = $core->mailer;
		$message = Message::from($message);

		return $mailer($message);
	}
}