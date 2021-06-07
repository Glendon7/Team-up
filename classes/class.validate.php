<?php

class Validate{

    private $_passed=false,
    $_errors=array(),
    $_db=null;


public function __construct(){
    $this->_db=Database::getInstance();
}

public function check($source,$items=array()){
    foreach($items as $item=>$rules){
        foreach($rules as $rule=>$rule_value){
           $value =trim($source[$item]);   //assigns what the user enters in an input field $_POST[username]
           $item=escape($item);
           if($rule === 'required' && empty($value)){
               $this->addError("{$item} is required");

           }else if(!empty($value)){
               switch($rule){

                case 'min':
                    if(strlen($value)< $rule_value){
                        $this->addError("{$item} must be atleast {$rule_value} characters long.");
                    }

                    break;
                
                case 'max':
                    if(strlen($value)> $rule_value){
                        $this->addError("{$item} cannot be greater than {$rule_value} characters.");
                    }

                    break;
                    
                case 'matches':
                    if($value !=$source[$rule_value]){
                        $this->addError("{$rule_value} must match {$item}");

                    }

                    break;
                    
                case 'unique':
                    $check= $this->_db->get($rule_value,array($item,'=',$value));
                    
                    if($check->count()){
                        $this->addError("{$item} already exist. ");
                    }

                    break;

                case 'before':
                    if($value<$source[$rule_value]){
                        $this->addError("Due date({$value}) cannot be before the start date ({$source[$rule_value]})");
                    }
                    
                case 'incorrect_date':
                    if($value<$rule_value){
                        $this->addError("Start date connot be before {$rule_value}" );
                    }
               }

           }
        }
    }
    if(empty($this->_errors)){
        $this->_passed=true;
    }
    return $this;
}

private function addError($error){
    $this->_errors[]= $error;
}

public function errors(){
    return $this->_errors;
}

public function passed(){
    return $this->_passed;
}
}