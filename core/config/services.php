<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],
	'mandrill' => [
		'secret' => '',
	],
	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],
	'stripe' => [
		'secret' => '',
		'status' => '',
		'key' => '',
	],
    'paypal'=>[
		'client_id' => '',
		'secret' => '',
		'status' => '',
		'account' => '',
		'mode' => '',
	],
    'license'=>[
		'is_verified' => '1',
		'purchase_code' => 'ad28a58c-9809-4139-9218-6837bf46c549',
	]
];
