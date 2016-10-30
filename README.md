# MutluSms plugin for CakePHP





## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require suhaboncukcu/mutlu-sms:dev-master

bin/cake load plugin MutluSms

bin/cake bake migrations migrate -p MutluSms
```


##Usage

```php
//anywhere in your application;

use MutluSms\Utility\MutluSms;

$mutluSmsHandler = new MutluSms([
						 'ka' => 'username',
						 'pwd' => 'password',
						 'org' => 'organisationName'
					]);

// METHOD 1
$mutluMessageId = $mutluSmsHandler->create(['message' => 'yourmessage', 'number' => 'targetnumber']);
$mutluSmsHandler->send($mutluMessageId);

// METHOD 2

$mutluSmsHandler->create(['message' => 'yourmessage1', 'number' => 'targetnumber1']);
$mutluSmsHandler->create(['message' => 'yourmessage2', 'number' => 'targetnumber2']);
$mutluSmsHandler->create(['message' => 'yourmessage3', 'number' => 'targetnumber3']);
$mutluSmsHandler->sendAll();


```
