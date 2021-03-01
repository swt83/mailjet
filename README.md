# Mailjet

A PHP library for working w/ the [Mailjet API](https://dev.mailjet.com/email/guides/).

## Install

Normal install via Composer.

## Usage

Call the ``run`` method:

```php
use Travis\Mailjet;

$apikey_public = 'your-api-key-public';
$apikey_secret = 'your-api-key-sercret';
$list_id = 'your-contact-list-id';

// add new subscriber
$test = Mailjet::run($apikey_public, $apikey_secret, 'contactslist/'.$list_id.'/managecontact', 'post', [
	'name' => 'Jack Bauer',
	'email' => 'jbauer@foobar.net',
	'action' => 'addforce',
]);
```