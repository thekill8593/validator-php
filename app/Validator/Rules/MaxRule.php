<?php

namespace App\Validator\Rules;

class MaxRule implements RuleInterface {

    protected $max;

    public function __construct($max)
    {
        $this->max = $max;
    }    

    public function getMax() {
        return $this->max;
    }

    function passes($field, $value) : bool {
       
        return strlen($value) <= $this->max;
    }

    function message($field) : string {
        return "$field must be less than $this->max characters";
    }
}