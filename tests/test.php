<?php

include 'calc.php';



class CalculatorTest extends PHPUnit_Framework_TestCase {


	/*
	 * Lets check for the operators first
	 */

	public function testIsInstanceOf()
	{
		$this->assertInstanceOf('operator', (new subtract()));
		$this->assertInstanceOf('operator', (new add()));
		$this->assertInstanceOf('operator', (new multiply()));
		$this->assertInstanceOf('operator', (new divide()));
		$this->assertInstanceOf('number', (new number(rand())));
	}

	/*
	 * @depends testIsInstanceOf
	 */
	public function testOperatorSubtractOperand(){
		$expected = '-';
		$actual = (new subtract())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testIsInstanceOf
	 */
	public function testOperatorAddOperand(){
		$expected = '+';
		$actual = (new add())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testIsInstanceOf
	 */
	public function testOperatorMultiplyOperand(){
		$expected = '*';
		$actual = (new multiply())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testIsInstanceOf
	 */
	public function testOperatorDivideOperand(){
		$expected = '/';
		$actual = (new divide())->getOperand();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends	testOperatorSubtractOperand
	 */
	public function testOperatorSubtractPrecedence(){
		$expected = 2;
		$actual = (new subtract())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends	testOperatorAddOperand
	 */
	public function testOperatorAddPrecedence(){
		$expected = 2;
		$actual = (new add())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testOperatorMultiplyOperand
	 */
	public function testOperatorMultiplyPrecedence(){
		$expected = 1;
		$actual = (new multiply())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testOperatorDivideOperand
	 */
	public function testOperatorDividePrecedence(){
		$expected = 1;
		$actual = (new divide())->getPrecedence();
		$this->assertEquals($actual, $expected);
	}

	/*
     * @expectedException InvalidNumberException
     * @expectedExceptionMessage not a valid number, please enter a valid number
     */
	public function testNumber(){
		(new number('C'));

		$expected = 1;
		$actual = (new number(1))->getNumber();
		$this->assertEquals($actual, $expected);
	}

	/*
	 * @depends testNumber
	 */
	public function testEquationArray(){
		$actual = (new equation);
		$this->assertEmpty($actual->getExpression());
	}

	/*
	 * @depends testEquationArray
	 */
	public function testEquationElements(){
		$actual = (new equation)
			->number(12)
			->add()
			->number(13)
			->subtract()
			->number(23);

		// test the number of elements
		$this->assertEquals(count($actual->getExpression()), 5);

		// lets test each part of the object
		$this->assertEquals($actual->getExpression()[0]->number, 12);
		$this->assertEquals($actual->getExpression()[2]->number, 13);
		$this->assertEquals($actual->getExpression()[4]->number, 23);
		$this->assertEquals($actual->getExpression()[1]->getOperand(), '+');
		$this->assertEquals($actual->getExpression()[3]->getOperand(), '-');
	}

	/*
	 * @depends testEquationElements
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testNoEvaluationOnCalculations(){

		(new calculator)->evaluate();
	}

	public function testCalculations(){

		$actual = (new calculator)->evaluate(
				(new equation)
				->number(12)
				->add()
				->number(13)
				->subtract()
				->number(23)
		);
		$expected = 2;
		$this->assertEquals($actual, $expected);

		$actual = (new calculator)->evaluate(
				(new equation)
				->number(1)
				->add()
				->number(1)
				->multiply()
				->number(3)
				->add()
				->number(1)
		);
		$expected = 5;
		$this->assertEquals($actual, $expected);

		$actual = (new calculator)->evaluate(
				(new equation)
				->number(1)
				->add()
				->number(1)
				->divide()
				->number(3)
				->add()
				->number(1)
		);
		$expected = 2.3333333333;
		$this->assertEquals($actual, $expected);


		// lets test this further, there are 2 issues not tested here
		// 1) in the event that you get 2 operators what happens
		// 2) in the event that you get 2 numbers what happens
	}

}