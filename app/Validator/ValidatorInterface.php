<?php

namespace App\Validator;

interface ValidatorInterface {
    function setRules(array $rules = []) : ValidatorInterface;
    function setCustomMessages(array $messages = []) : ValidatorInterface;
    function validate() : bool;
}