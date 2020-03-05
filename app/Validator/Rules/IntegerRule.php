<?php

namespace App\Validator\Rules;

class IntegerRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_int($value);
    }

    function message($field) : string {
        return "$field must be an integer";
    }
}