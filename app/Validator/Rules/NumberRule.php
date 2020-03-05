<?php

namespace App\Validator\Rules;

class NumberRule implements RuleInterface {

    function passes($field, $value) : bool {
        return is_numeric($value);
    }

    function message($field) : string {
        return "$field must a be number";
    }
}