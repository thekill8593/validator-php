<?php

namespace App\Validator\Rules;

class RequiredRule implements RuleInterface {

    function passes($field, $value) : bool {
        return !empty($value);
    }

    function message($field) : string {
        return "$field is required";
    }
}