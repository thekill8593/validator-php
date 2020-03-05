<?php

namespace App\Validator\Rules;

class EmailRule implements RuleInterface {

    function passes($field, $value) : bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    function message($field) : string {        
        return "$field is incorrect";        
    }
}