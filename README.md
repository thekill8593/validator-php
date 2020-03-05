# Validator class

A tiny validator class for PHP, feel free to use it.

## Usage

```php
//data to validate
$data = [
	'name' => 'Jonathan',
	'email' => 'fake@gmail.com'
];

//instanciate class validator, and pass array of data to validate
$validator = new  Validator($data);

//set validation rules
$validator->setRules([
	'name' => ['required', 'max:50'],
	'email' => ['required', 'email']
]);

//method validate() returns a boolean
if (!$validator->validate()) {
	//if validation fails you can get the error messages
	//with the getErrors() method
	//getErrors() returns a detailed array with the errors
	$errors = $validator->getErrors();		
} else {
	//validation pass
}
```

## List of rules

```
| Rule           | Usage        
| -------------  | -------------
| Required       | required 
| Max Characters | max:(number) e.g. max:20   
| Min Characters | min:(number) e.g. min:6
| Email          | email
| Numeric        | number
| Integer        | integer
| String         | string
| Boolean        | bool
| Array          | array
| Equals         | equalsTo:(value to compare) e.g. equalsTo:"password1"
| Url            | url
| IP address     | ip
| Credit card    | creditCard
```
## Custom messages

```php
//instanciate class validator, and pass array of data to validate
$validator = new  Validator([
	'name' => 'Jonathan',
	'email' => 'fake@gmail.com'
]);

//set validation rules
$validator->setRules([
	'name' => ['required', 'max:50'],
	'email' => ['required', 'email']
]);

//you can call setCustomMessages() method
//and pass an array with the messages you want to override
$validator->setCustomMessages([
	'email' => [
		'required' => 'Custom message here'
	],
	...
]);

```

You can also use the validator instance in this way

```php
//instanciate class validator, and pass array of data to validate
$validator = new  Validator([
	'name' => 'Jonathan',
	'email' => 'fake@gmail.com'
]);

//set validation rules
$validation = $validator->setRules([
	'name' => ['required', 'max:50'],
	'email' => ['required', 'email']
])->setCustomMessages([
	'email' => [
		'required' => 'Custom message here'
	],	
])->validate();

if (!$validation) {
	//validation failed
} else {
	//validation passed
}
```
## Validate equals

If you need to validate whether two passwords are equals, then you can use the validation rule equalsTo.
```php

$password1 = "cat123";
$password2 = "cat123";

//instanciate class validator, and pass array of data to validate
$validator = new  Validator([
	'password' => $password1
]);

//set validation rules
$validation = $validator->setRules([
	'password' => ['required', 'min:6', "equalsTo:$password2"]
])->validate();

if (!$validation) {
	//validation failed
} else {
	//validation passed
}
```

