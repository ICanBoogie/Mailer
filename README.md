# Mailer [![Build Status](https://travis-ci.org/ICanBoogie/Mailer.svg?branch=master)](https://travis-ci.org/ICanBoogie/Mailer)

Mailer is a library for PHP that is designed to handle emails generation and sending.





### Acknowledgement

This package was inspired by the following softwares or articles:

- <https://github.com/mikel/mail>
- <http://swiftmailer.org/>
- <http://tools.ietf.org/html/rfc5322>





## Creating messages

```php
<?php

use ICanBoogie\Mailer\Message;

$message = new Message([

	'from' => [ 'olivier@example.com' => "Olivier Laviale" ]
	'to' => "Person name<person@example.com>, person2@example.com",
	'subject' => "Testing message",
	'body' => "Hello world!"

]);

echo $message->header; // Content-Type: text/plain; charset=UTF-8\r\nFrom: Olivier Laviale <olivier@ex…
echo $message;         // Hello world!
```





## ICanBoogie _auto-config_

The package supports the _auto-config_ feature of the framework [ICanBoogie][] and provides the
following features:

- The lazy getter for the `ICanBoogie\Core::$mailer` property that returns a [Mailer][] instance.
- The `ICanBoogie\Core::mailer` method that sends a message using the mailer.

```php
<?php

$core = new ICanBoogie\Core(ICanBoogie\get_autoconfig());

$core->mailer; //instace of ICanBoogie\Mailer\Mailer;
$core->mail([

	'to' => "example@example.com",
	'from' => "me@example.com",
	'subject' => "Testing",
	'body' => "Hello world!"

], $options = []);
```




### Before and after the message is sent

If `sender` is defined in the `mail()` options the following events are triggered:

- The `<class>:mail:before` event of class [BeforeMailEvent][] is fired before the message
is sent by the mailer. Third parties may use this event to alter the message or the mailer that
will be used to send it.
- The `<class>:mail` event of class [MailEvent][] is fired after the message was sent by the
mailer. Third parties may use this event to alter the result returned by the mailer.

Where `<class>` is the class of the sender.





----------





## Requirements

The package requires PHP 5.4 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/mailer
```






### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/Mailer), its repository can be
cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/Mailer.git





## Documentation

The documentation can be generated for the package and its dependencies with the `make doc`
command. The documentation is generated in the `docs` directory. [ApiGen](http://apigen.org/) is
required. The directory can later be cleaned with the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all the dependencies required to run the suite.
The directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://travis-ci.org/ICanBoogie/Mailer.svg?branch=master)](https://travis-ci.org/ICanBoogie/Mailer)





## License

This package is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.




[BeforeMailEvent]: http://icanboogie.org/docs/class-ICanBoogie.Mailer.BeforeMailEvent.html
[ICanBoogie]: http://icanboogie.org
[Mailer]: http://icanboogie.org/docs/class-ICanBoogie.Mailer.Mailer.html
[MailEvent]: http://icanboogie.org/docs/class-ICanBoogie.Mailer.MailEvent.html
