<?php

namespace App\Validator\Rules;

class EqualsRule implements RuleInterface {

    protected $equalsValue;

    public function __construct($equalsValue) {
        $this->equalsValue = $equalsValue;
    }

    function passes($field, $value) : bool {
        return $value === $this->equalsValue;
    }

    function message($field) : string {
        return "$field doesn't match";
    }
}