<?php

/*
 * Objective is to create a calculator
 *
 */

class InvalidNumberException extends Exception;
class DivisionByZeroException extends Exception;

/*
 * Define what objects the calculator will have
 * We're going to need operators
 */
abstract class operator {
	protected $precedence;
	protected $operand;

	public function getOperand(){
		return $this->operand;
	}

	public function getPrecedence(){
		return $this->precedence;
	}
}

/*
 * Lets define the different types of operators
 */
class multiply extends operator {
	public function __construct(){
		$this->precedence = 1;
		$this->operand = chr(42);
	}
}

class divide extends operator {
	public function __construct(){
		$this->precedence = 1;
		$this->operand = chr(47);
	}
}

class add extends operator {
	public function __construct(){
		$this->precedence = 2;
		$this->operand = chr(43);
	}
}

class subtract extends operator {
	public function __construct(){
		$this->precedence = 2;
		$this->operand = chr(45);
	}
}
