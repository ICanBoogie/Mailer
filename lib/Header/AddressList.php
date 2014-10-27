<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Mailer\Header;

/**
 * Representation of a _addresses_ header.
 */
class AddressList extends \ICanBoogie\Mailer\AddressList
{
	public function __toString()
	{
		$rc = '';

		foreach ($this->address_list as $mailbox => $display_name)
		{
			if ($rc)
			{
				$rc .= ",\r\n\t";
			}

			if ($display_name === true)
			{
				$rc .= $mailbox;

				continue;
			}

			if (!mb_check_encoding($display_name, 'ASCII'))
			{
				$display_name = mb_encode_mimeheader($display_name);
			}
			else
			{
				$display_name = self::escape_display_name($display_name);
			}

			$rc .= "$display_name <$mailbox>";
		}

		return $rc;
	}
}
