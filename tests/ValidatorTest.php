<?php

use App\Validator\Exception\ValidatorRulesEmptyException;
use App\Validator\Rules\EmailRule;
use App\Validator\Rules\RequiredRule;
use App\Validator\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase {

	/** @test **/
	public function can_set_data() {
        $data = [
            'name' => 'jonathan',
            'email' => 'fake@gmail.com'
        ];
        $validator = new Validator($data);
        $this->assertEquals($data, $validator->getData());
    }
    
    /** @test **/
	public function can_set_rules() {       
        $validator = new Validator([
            'name' => 'jonathan'            
        ]);

        $validator->setRules([
            'name' => ['required']
        ]);

        $rules = $validator->getRules();        
       
        $this->assertInstanceOf(RequiredRule::class, $rules['name']['required']);
    }
    
    /** @test **/
	public function can_set_rules_with_params() {       
        $validator = new Validator([
            'name' => 'jonathan'            
        ]);

        $validator->setRules([
            'name' => ['min:6']
        ]);

        $rules = $validator->getRules();      
        
        $min = $rules['name']['min']->getMin();
       
        $this->assertEquals(6, $min);
    }

    /** @test **/
	public function can_set_multiple_rules() {       
        $validator = new Validator([
            'email' => 'fake@gmail.com'            
        ]);

        $validator->setRules([
            'email' => ['required', 'email']
        ]);

        $rules = $validator->getRules();      
        
        $this->assertInstanceOf(RequiredRule::class, $rules['email']['required']);
        $this->assertInstanceOf(EmailRule::class, $rules['email']['email']);
    }

    /** @test **/
	public function can_validate_multiple_fields() {       
        $validator = new Validator([
            'name' => 'jonathan',
            'email' => 'fake@gmail.com'            
        ]);

        $validator->setRules([
            'email' => ['email'],
            'name' => ['required']
        ]);

        $rules = $validator->getRules();      
        
        $this->assertInstanceOf(EmailRule::class, $rules['email']['email']);
        $this->assertInstanceOf(RequiredRule::class, $rules['name']['required']);
    }


    /** @test **/
	public function validation_passes() {       
        $validator = new Validator([
            'name' => 'jonathan',
            'email' => 'fake@gmail.com'            
        ]);

        $validator->setRules([
            'email' => ['email'],
            'name' => ['required']
        ]);
        
        $this->assertEquals($validator->validate(), true);        
    }

    /** @test **/
	public function validation_fails() {       
        $validator = new Validator([
            'name' => 'jonathan',
            'email' => 'fakmail.com'            
        ]);

        $validator->setRules([
            'email' => ['email'],
            'name' => ['required']
        ]);
        
        $this->assertEquals($validator->validate(), false);        
    }

    /** @test **/
	public function validator_return_error_messages() {       
        $validator = new Validator([            
            'email' => ''
        ]);
        
        $validator->setRules([
            'email' => ['required']            
        ])->validate();        

        $errors = $validator->getErrors();
        
        $this->assertEquals($errors['email']['required'], 'Email is required');        
    }

    /** @test **/
    public function validator_throws_validator_rules_empty_exception_if_rules_array_is_empty() {

        $this->expectException(ValidatorRulesEmptyException::class);

        $validator = new Validator([
            'name' => 'jonathan',                     
        ]);

        $validator->setRules([]);        
    }


    /** @test **/
    public function can_set_custom_messages() {
        $validator = new Validator([
            'email' => ''    
        ]);
        
        $validator->setRules([
            'email' => ['required', 'email'],   
        ])->setCustomMessages([
            'email' => [
                'required' => 'Email is a required field.'                
            ]
        ])->validate();

        $errors = $validator->getErrors();

        $this->assertEquals($errors['email']['required'], 'Email is a required field.');            
    }


    /**===============================
        VALIDATING RULES
    =============================== */
    /** @test **/
    public function validates_required() {
        $validator = new Validator([
            'email' => ''    
        ]);
        
        $result = $validator->setRules([
            'email' => ['required'],   
        ])->validate();      

        $this->assertEquals($result, false);            
    }

    /** @test **/
    public function validates_email() {
        $validator = new Validator([
            'email' => 'fake@gmacom'    
        ]);
        
        $result = $validator->setRules([
            'email' => ['email'],   
        ])->validate();      

        $this->assertEquals($result, false);            
    }

    /** @test **/
    public function validates_min() {
        $validator = new Validator([
            'name' => 'jonat'    
        ]);
        
        $result = $validator->setRules([
            'name' => ['min:6'],   
        ])->validate();      

        $this->assertEquals($result, false);            
    }


    /** @test **/
    public function validates_max() {
        $validator = new Validator([
            'name' => 'jonathan'    
        ]);
        
        $result = $validator->setRules([
            'name' => ['max:6'],   
        ])->validate();      

        $this->assertEquals($result, false);            
    }

    /** @test **/
    public function validates_number() {
        $validator = new Validator([
            'a' => 20,
            'b' => -20,
            'c' => 20.1            
        ]);
        
        $result = $validator->setRules([
            'a' => ['number'],   
            'b' => ['number'],   
            'c' => ['number'],            
        ])->validate();      

        $this->assertEquals($result, true);            
    }


    /** @test **/
    public function validates_integer() {
        $validator = new Validator([          
            'a' => 20.1            
        ]);
        
        $result = $validator->setRules([
            'a' => ['integer']                     
        ])->validate();      

        $this->assertEquals($result, false);            
    }

    /** @test **/
    public function validates_float() {
        $validator = new Validator([          
            'a' => 20           
        ]);
        
        $result = $validator->setRules([
            'a' => ['float']                     
        ])->validate();      

        $this->assertEquals($result, false);            
    }

    /** @test **/
    public function validates_string() {
        $validator = new Validator([          
            'a' => 20           
        ]);
        
        $result = $validator->setRules([
            'a' => ['string']                     
        ])->validate();      

        $this->assertEquals($result, false);            
    }


    /** @test **/
    public function validates_array() {
        $validator = new Validator([          
            'a' => [20, 30]           
        ]);
        
        $result = $validator->setRules([
            'a' => ['array']                     
        ])->validate(); 

        $this->assertEquals($result, true);            
    }

    /** @test **/
    public function validates_equals() {

        $password1 = "cat123";
        $password2 = "cat123";

        $validator = new Validator([          
            'password' => $password1         
        ]);
        
        $result = $validator->setRules([
            'password' => ["equalsTo:$password2"]
        ])->validate(); 

        $this->assertEquals($result, true);            
    } 


    /** @test **/
    public function validates_url() {

        $validator = new Validator([          
            'link' => "https://github.com/"         
        ]);
        
        $result = $validator->setRules([
            'link' => ["url"]
        ])->validate(); 

        $this->assertEquals($result, true);            
    } 

    /** @test **/
    public function validates_ip_address() {

        $validator = new Validator([          
            'address' => "192.168.0.1"         
        ]);
        
        $result = $validator->setRules([
            'address' => ["ip"]
        ])->validate(); 

        $this->assertEquals($result, true);            
    } 

    /** @test **/
    public function validates_credit_card() {

        $validator = new Validator([          
            'card' => "4195905348577260"   
        ]);
        
        $result = $validator->setRules([
            'card' => ["creditCard"]
        ])->validate(); 

        $this->assertEquals($result, true);            
    } 

    


}