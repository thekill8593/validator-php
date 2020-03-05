<?php

namespace App\Validator;

use App\Validator\Exception\ArrayException;
use App\Validator\Exception\EmptyException;
use App\Validator\Exception\ValidatorRulesEmptyException;

class Validator implements ValidatorInterface{

    protected $rules = [];
    protected $errorMessages = [];
    protected $data = [];
    protected $customMessages = [];

    public function __construct($data)
    {
        if (empty($data)) {
            throw new EmptyException("The data to validate must not be empty");
        }

        if (!is_array($data)) {
            throw new ArrayException("The data to validate must be an array");
        }        

        $this->data = $data;
    } 

    public function setRules(array $rules = []) : ValidatorInterface {
        if (count($rules) === 0) {
            throw new ValidatorRulesEmptyException("Rules array must not be empty");
        }

        $map = new RulesMap();

        foreach ($rules as $key => $field) {
            $fieldRules = [];
            foreach ($field as $rule) {
                $rule = $this->checkOptions($rule);  
                $ruleName = is_array($rule) ? $rule[0] : $rule;
                $ruleOptions = is_array($rule) ? $rule[1] : [];
                $ruleClass = $map->resolve($ruleName, [$ruleOptions]);

                $fieldRules += [$ruleName => $ruleClass];
            }
            $this->rules += [$key => $fieldRules];
            
        }      
        
        return $this;
    }

    public function validate() : bool {       

        $isValid = true;       
        
        foreach ($this->rules as $key => $rule) {
            $data = isset($this->data[$key]) ? $this->data[$key] : "";            
            $error = [];
            foreach($rule as $ruleName => $ruleClass) {                
                if (!$ruleClass->passes($key, $data)) {
                    if (isset($this->customMessages[$key][$ruleName])) {
                        $error += [$ruleName => $this->customMessages[$key][$ruleName]];
                    } else {
                        $error += [$ruleName => $ruleClass->message(ucfirst($key))];
                    }
                    
                    $isValid = false;
                }
            }        
            count($error) > 0 && $this->errorMessages += [$key => $error];
        } 
        
        return $isValid;
    }

    public function setCustomMessages(array $messages = []) : ValidatorInterface {
        $this->customMessages = $messages;
        return $this;
    }

    public function getErrors() : array {
        return $this->errorMessages;
    }

    public function getData() : array {
        return $this->data;
    }

    public function getRules() : array {
        return $this->rules;
    }

    protected function checkOptions($rule) {
        if (strpos($rule, ':') === false) {
            return $rule;
        } else {
            return explode(":", $rule);
        }
    }
}