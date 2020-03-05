<?php

namespace App\Validator\Rules;

class BoolRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_bool($value);
    }

    function message($field) : string {
        return "$field must be a boolean";
    }
}