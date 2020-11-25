<?php

namespace App\Tests;

use App\Method;
use App\Argument;
use App\Exception\AnonymousArgumentException;
use App\Exception\DuplicateArgumentException;
use App\Exception\InvalidNameException;
use PHPUnit\Framework\TestCase;

final class MethodTest extends TestCase
{	
	final public function test_argument_is_added()
	{
		// given
		$method = new Method('method');
		$argument = new Argument('argument');

		// when
		$method->addArgument($argument);
		
		// then
		$this->assertCount(1, $method->getArguments());
	}

	final public function test_rejects_duplicate_argument()
	{
		// given
		$method = new Method('method');
		$argument = new Argument('argument');

		// when
		$method->addArgument($argument);
		
		// then
		$this->expectException(DuplicateArgumentException::class);
		$method->addArgument($argument);
	}

	final public function test_detects_arguments()
	{
		// given
		$method = new Method('method');
		$argument = new Argument('argument');

		// when
		$method->addArgument($argument);
		
		// then
		$this->assertTrue($method->hasArguments());
	}

	final public function test_argument_dependencies_are_added_to_method_ones()
	{
		// given
		$method = new Method('method');
		$argument = (new Argument('argument'))->setType(TestCase::class);

		// when
		$method->addArgument($argument);
		
		// then
		$this->assertCount(1, $method->getDependencies());
	}

	final public function test_minimal_declaration()
	{
		// given
		$method = new Method('method');
		
		// when
		
		// then
		$this->expectOutputString(file_get_contents('tests/templates/methods/minimal.txt'));
		$method->getDeclaration();
	}
}