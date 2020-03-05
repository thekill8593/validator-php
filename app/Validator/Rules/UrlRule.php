<?php

namespace App\Validator\Rules;

class UrlRule implements RuleInterface {

    function passes($field, $value) : bool {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    function message($field) : string {
        return "$field must be a valid URL";
    }
}