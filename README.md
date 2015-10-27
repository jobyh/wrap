#Wrap Function

You've got a string - yay! `:)` it's too long - boo `:(` - you decided for no particular reason never to use PHP's built-in [wordwrap](http://php.net/manual/en/function.wordwrap.php) function? In steps the incredible `wrap` function!

##Requirements

- PHP >= 5.3.3 'cus we got your back (even though we cant use the new shiny stuff)
- [Composer](https://getcomposer.org/) (Optional. For unit tests).

##Installation

Clone the repository and use `composer` to install test dependencies.

```
% cd /path/to/install/dir
% git clone https://github.com/jobyh/wrap.git
% composer install
```

##Usage

```
<?php

require_once('/path/to/wrap/src/wrap.php');

wrap('My long string to wrap!', 7);
```

##Tests

From inside the cloned project root run the PHPUnit tests:

```
% ./vendor/bin/phpunit
```
