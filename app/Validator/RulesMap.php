<?php

namespace App\Validator;

use App\Validator\Rules\ArrayRule;
use App\Validator\Rules\BoolRule;
use App\Validator\Rules\CreditCardRule;
use App\Validator\Rules\EmailRule;
use App\Validator\Rules\EqualsRule;
use App\Validator\Rules\FloatRule;
use App\Validator\Rules\IntegerRule;
use App\Validator\Rules\IPRule;
use App\Validator\Rules\MaxRule;
use App\Validator\Rules\MinRule;
use App\Validator\Rules\NumberRule;
use App\Validator\Rules\RequiredRule;
use App\Validator\Rules\StringRule;
use App\Validator\Rules\UrlRule;

class RulesMap {
    protected static $map = [
        'required' => RequiredRule::class,
        'max' => MaxRule::class,
        'min' => MinRule::class,
        'email' => EmailRule::class,
        'number' => NumberRule::class,
        'integer' => IntegerRule::class,
        'float' => FloatRule::class,
        'string' => StringRule::class,       
        'bool' => BoolRule::class,
        'array' => ArrayRule::class,
        'equalsTo' => EqualsRule::class,
        'url' => UrlRule::class,
        'ip' => IPRule::class,
        'creditCard' => CreditCardRule::class
    ];

    public static function resolve($rule, $options)  {            
        return new static::$map[$rule](...$options);
    }
}