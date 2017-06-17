<?php

return [
	'security_code' => env('SECURITY_CODE', '4DeZPLFgZikoHWJx4vR3suoDaWBmjvkL9UM7hGlvMU4='),
	'roles' => [
		'admin' => 'Admin',
		'user' => 'User',
	],
	'record_from' => [
		'input', 'mobile'
	],
	'assets' => [
		'image' => 'uploads/images'
	],
	'gifts' => [
		'dollar' => true,
		'khmer' => true,
		'bat' => false,
		'dong' => false,
		'dowry' => true
	]
];