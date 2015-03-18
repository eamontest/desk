<?php

include 'calc.php';



class CalculatorTest extends PHPUnit_Framework_TestCase {


	/*
	 * Lets check for the operators first
	 */
	public function testOperatorSubtractOperand(){
		$expected = '-';
		$actual = (new subtract())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorAddOperand(){
		$expected = '+';
		$actual = (new add())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorMultiplyOperand(){
		$expected = '*';
		$actual = (new multiply())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorDivideOperand(){
		$expected = '/';
		$actual = (new divide())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorSubtractPrecedence(){
		$expected = 2;
		$actual = (new subtract())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorAddPrecedence(){
		$expected = 2;
		$actual = (new add())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorMultiplyPrecedence(){
		$expected = 1;
		$actual = (new multiply())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	public function testOperatorDividePrecedence(){
		$expected = 1;
		$actual = (new divide())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * Lets check numbers
	 */

	/*
	 * $value = (new calculator)->evaluate(
				(new equation)
				->number(12)
				->add()
				->number(13)
				->subtract()
				->number(23)
		);
		print $value;
	 */
}