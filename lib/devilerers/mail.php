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
 * Delivers message using the `mail()` function.
 */
class MailDeliverer implements Deliverer
{
	public function deliver(Message $message)
	{
		$to = (string) $message->to;
		$subject = (string) $message->subject;
		$body = (string) $message;

		$charset = mb_detect_encoding($subject);

		if ($charset != 'ASCII')
		{
			$subject = mb_convert_encoding($subject, 'UTF-8');
			$subject = mb_encode_mimeheader($subject, 'UTF-8');
		}

		$header = clone $message->header;

		unset($header['To']);
		unset($header['Subject']);

		return mail($to, $subject, $body, $header);
	}
}