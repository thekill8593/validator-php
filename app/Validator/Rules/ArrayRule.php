<?php

namespace App\Validator\Rules;

class ArrayRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_array($value);
    }

    function message($field) : string {
        return "$field must be an array";
    }
}