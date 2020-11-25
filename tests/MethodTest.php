<?php

namespace App\Tests;

use App\Method;
use App\Argument;
use App\Exception\AbstractMethodDefinitionException;
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
		$this->assertEquals(
			file_get_contents('tests/templates/methods/minimal.txt'),
			$method->getDeclaration()
		);
	}
	
	final public function test_declaration_with_return_type()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->setType(TestCase::class);

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/minimal-return.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_declaration_with_one_argument()
	{
		// given
		$method = new Method('method');
		$argument = (new Argument('case'))->setType(TestCase::class);

		// when
		$method->addArgument($argument);

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/one-argument.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_declaration_with_many_arguments()
	{
		// given
		$method = new Method('method');
		$a = (new Argument('a'))->setType('string');
		$b = (new Argument('b'))->setType('int');
		$c = (new Argument('c'))->setType('bool');

		// when
		$method
			->addArgument($a)
			->addArgument($b)
			->addArgument($c)
		;

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/three-arguments.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_declaration_with_scope()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->makePublic();

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/scope.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_declaration_with_expandability()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->makeAbstract();

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/expandability.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_goes_static()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->makeStatic();

		// then
		$this->assertTrue($method->isStatic());
	}

	final public function test_declaration_with_static()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->makeStatic();

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/static.txt'),
			$method->getDeclaration()
		);
	}

	final public function test_minimal_doc_block()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->setComment('Some method');

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/minimal-comment.txt'),
			$method->getDocBlock()
		);
	}

	final public function test_doc_block_with_arguments()
	{
		// given
		$method = new Method('method');
		$case = new Argument('case');
		$message = new Argument('message');

		// when
		$case
			->setType(TestCase::class)
			->setComment('the case')
		;
		$message
			->setType('string')
			->setComment('the message')
		;
		$method
			->setComment('Some method')
			->addArgument($case)
			->addArgument($message)
		;

		// then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/comment-arguments.txt'),
			$method->getDocBlock()
		);
	}

	final public function test_abstract_can_not_be_defined()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->makeAbstract();

		//then
		$this->expectException(AbstractMethodDefinitionException::class);
		$method->getDefinition();
	}

	final public function test_minimal_definition()
	{
		// given
		$method = new Method('method');
		
		// when
		
		//then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/minimal-definition.txt'),
			$method->getDefinition()
		);
	}

	final public function test_definition_self_return()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->setType(Method::FLUENT);

		//then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/definition-self-return.txt'),
			$method->getDefinition()
		);
	}

	final public function test_definition_with_statement()
	{
		// given
		$method = new Method('method');
		
		// when
		$method->addStatement('echo "trololo"');

		//then
		$this->assertEquals(
			file_get_contents('tests/templates/methods/definition-statement.txt'),
			$method->getDefinition()
		);
	}
}