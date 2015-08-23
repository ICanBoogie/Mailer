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
 * Delivers emails into multiple files based on the destination address. Each file is appended to
 * if it already exists.
 */
class FileDeliverer implements Deliverer
{
	/**
	 * @var string
	 */
	protected $location;

	/**
	 * @param string $location
	 */
	public function __construct($location)
	{
		$this->location = $location;
	}

	/**
	 * @inheritdoc
	 */
	public function deliver(Message $message)
	{
		$location = $this->location . DIRECTORY_SEPARATOR;

		if (!file_exists($location))
		{
			mkdir($location);
		}

		foreach ($message->to as $email => $name)
		{
			$fh = fopen($location . $email, 'a');

			fputs($fh, "{$message->header}\r\n{$message}\r\n\r\n");
		}
	}
}
