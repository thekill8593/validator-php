<?php

namespace App\Validator\Rules;

class FloatRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_float($value);
    }

    function message($field) : string {
        return "$field must be a decimal number";
    }
}