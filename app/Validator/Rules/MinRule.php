<?php

namespace App\Validator\Rules;

class MinRule implements RuleInterface {

    protected $min;

    public function __construct($min)
    {
        $this->min = $min;
    }    

    public function getMin() {
        return $this->min;
    }

    function passes($field, $value) : bool {
       
        return strlen($value) >= $this->min;
    }

    function message($field) : string {
        return "$field must be at least $this->min characters";
    }
}