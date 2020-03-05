<?php

namespace App\Validator\Rules;

interface RuleInterface {
    function passes($field, $value) : bool;
    function message($field) : string;
}