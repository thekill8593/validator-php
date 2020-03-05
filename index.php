<?php

require './vendor/autoload.php';

use App\Validator\Validator;

$validator = new Validator([
    'email' => 'fake@gmlcom'    
]);

$validator->setRules([
    'email' => ['required', 'email'],   
]);

if ($validator->validate()) {
    var_dump("ok");
} else {    
    var_dump($validator->getErrors());
}



