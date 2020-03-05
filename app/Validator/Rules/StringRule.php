<?php

namespace App\Validator\Rules;

class StringRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_string($value);
    }

    function message($field) : string {
        return "$field must be a string";
    }
}