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
