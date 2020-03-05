<?php

namespace App\Validator\Rules;

class IPRule implements RuleInterface {

    function passes($field, $value) : bool {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    function message($field) : string {
        return "$field must be a valid IP address";
    }
}