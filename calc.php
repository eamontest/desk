<?php

/*
 * Objective is to create a calculator
 *
 */

class InvalidNumberException extends Exception {};
class DivisionByZeroException extends Exception {};

/*
 * Define what objects the calculator will have
 * We're going to need operators
 */
abstract class operator {
	protected $precedence;
	protected $operand;

	public function __construct(){}

	public function getOperand(){
		return $this->operand;
	}

	public function getPrecedence(){
		return $this->precedence;
	}

	public function __toString(){
		return $this->getOperand();
	}
}

/*
 * Lets define the different types of operators
 */
class multiply extends operator {
	public function __construct(){
		parent::__construct();
		$this->precedence = 1;
		$this->operand = chr(42);
	}
}

class divide extends operator {
	public function __construct(){
		parent::__construct();
		$this->precedence = 1;
		$this->operand = chr(47);
	}
}

class add extends operator {
	public function __construct(){
		parent::__construct();
		$this->precedence = 2;
		$this->operand = chr(43);
	}
}

class subtract extends operator {
	public function __construct(){
		parent::__construct();
		$this->precedence = 2;
		$this->operand = chr(45);
	}
}

/*
 * We're going to need numbers
 */
class number {
	public function __construct($number){
		// only allow positive numbers or floats
		if((!is_int($number) or !is_float($number)) && $number < 0){
			throw new InvalidNumberException($number  . ' is not a valid number, please enter a valid number');
		}
		$this->number = $number;
	}

	public function getNumber(){
		return $this->number;
	}

	public function __toString(){
		return (string)$this->number;
	}
}

/*
 * So to calculate we need an expression
 * TODO: extend so it has brackets, percentage, scienctific functions
 */
class equation {
	protected $equation = [];

	public function __construct(){
		// set this so it resets the array each time
		$this->equation = [];
	}

	public function number($number){
		$this->equation[] = new number($number);
		return $this;
	}

	public function add(){
		$this->equation[] = new add();
		return $this;
	}

	public function subtract(){
		$this->equation[] = new subtract();
		return $this;
	}

	public function multiply(){
		$this->equation[] = new multiply();
		return $this;
	}

	public function divide(){
		$this->equation[] = new divide();
		return $this;
	}

	public function getExpression(){
		return $this->equation;
	}
}

/*
 * Now we need an object to calculate, could posibily extend to manage multiple equations
 * Think it's time for me to get phpunit involve here now i've decided on best method from the options
 */
class calculator {

	protected $skipkey = null;

	public function evaluate(equation $equation){

		// store the functional operations
		$fx = [];

		// get our arguments
		$args = (array)$equation->getExpression();

		//iterate through the array
		foreach($args as $key => $part){

			// skip the keys we won't be needing
			if($this->skipkey === $key) continue;

			// get numbers
			if(is_a($part, 'number')){
				$fx[$key] = $part->getNumber();
			}

			// this is for the operators to examine the array
			if(is_a($part, 'operator')){

				if($part->getPrecedence() == 1){
					$total = 0;
					// lets calculate
					if($part->getOperand() == '*')
						$total += $args[$key-1]->getNumber() * $args[$key+1]->getNumber();
					if($part->getOperand() == '/')
						$total += $args[$key-1]->getNumber() / $args[$key+1]->getNumber();

					// set this to the previous key
					$fx[$key-1] = $total;

					// remove this key
					$this->skipkey = $key+1;
				} else {
					$fx[$key] = $part->getOperand();
				}
			}
		}

		// lets evaluate each of the remaining parts
		$total = 0;
		foreach($fx as $part){
			$total .= $part;
		}

		// only allow digits at this stage
		if(!preg_match('|[\d\+\_]+|', $total)){
			return false;
		}

		// hate this function, strapped for time
		eval('$total = ' .$total . ';');

		// return the total
		return $total;
	}
}

