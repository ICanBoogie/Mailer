# Mailer

[![Release](https://img.shields.io/packagist/v/icanboogie/mailer.svg)](https://packagist.org/packages/icanboogie/mailer)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Mailer/master.svg)](http://travis-ci.org/ICanBoogie/Mailer)
[![HHVM](https://img.shields.io/hhvm/icanboogie/mailer.svg)](http://hhvm.h4cc.de/package/icanboogie/mailer)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Mailer/master.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Mailer)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Mailer/master.svg)](https://coveralls.io/r/ICanBoogie/Mailer)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/mailer.svg)](https://packagist.org/packages/icanboogie/mailer)


Mailer is a library for PHP that is designed to handle emails generation and sending.





### Acknowledgement

This package was inspired by the following software or articles:

- <https://github.com/mikel/mail>
- <http://swiftmailer.org/>
- <http://tools.ietf.org/html/rfc5322>





### ICanBoogie binding

The package may be bound to [ICanBoogie][] with the [icanboogie/bind-mailer][] package.





## Creating a message

```php
<?php

use ICanBoogie\Mailer\Message;

$message = new Message([

	'from' => [ 'olivier@example.com' => "Olivier Laviale" ]
	'to' => "Person name<person@example.com>, person2@example.com",
	'subject' => "Testing message",
	'body' => "Hello world!"

]);

# or

$message = Message::from([ … ]);

echo $message->header; // Content-Type: text/plain; charset=UTF-8\r\nFrom: Olivier Laviale <olivier@ex…
echo $message;         // Hello world!
```





## Sending a message

Messages are sent by a _deliverer_ through a [Mailer][] instance.

The following example demonstrates how a mailer can be used to send emails using the default _mail_
deliverer:

```php
<?php

use ICanBoogie\Mailer\Mailer;

$mailer = new Mailer;
$rc = $mailer($message);
```

The following example demonstrates how a mailer can be used to send emails using the _file_
deliverer:

```php
<?php

use ICanBoogie\Mailer\Mailer;
use ICanBoogie\Mailer\FileDeliverer;

$mailer = new Mailer(new FileDeliverer('/path/to/my/file');
$rc = $mailer($message);
```





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

The package is documented as part of the [ICanBoogie][] framework
[documentation][]. You can generate the documentation for the package
and its dependencies with the `make doc` command. The documentation is generated in the
`build/docs` directory. [ApiGen](http://apigen.org/) is required. The directory can later be
cleaned with the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [PHPUnit](https://phpunit.de/) and
[Composer](http://getcomposer.org/) need to be globally available to run the suite. The command
installs dependencies as required. The `make test-coverage` command runs test suite and also
creates an HTML coverage report in "build/coverage". The directory can later be cleaned with
the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/Mailer/master.svg)](http://travis-ci.org/ICanBoogie/Mailer)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Mailer/master.svg)](https://coveralls.io/r/ICanBoogie/Mailer)





## License

**icanboogie/mailer** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.




[ICanBoogie]: http://icanboogie.org
[icanboogie/bind-mailer]: https://github.com/ICanBoogie/bind-mailer
[documentation]: http://api.icanboogie.org/mailer/1.1/
[Mailer]: http://api.icanboogie.org/mailer/1.1/class-ICanBoogie.Mailer.Mailer.html
