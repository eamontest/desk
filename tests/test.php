<?php

include 'calc.php';



class CalculatorTest extends PHPUnit_Framework_TestCase {

	public function operator(){

		$value = (new calculator)->evaluate(
				(new equation)
				->number(12)
				->add()
				->number(13)
				->subtract()
				->number(23)
		);
		print $value;
	}
}