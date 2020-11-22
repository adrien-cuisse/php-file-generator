<?php

namespace App\Tests;

use App\Method;
use App\Argument;
use App\Exception\AnonymousArgumentException;
use App\Exception\AnonymousMethodException;
use App\Exception\DuplicateArgumentException;
use App\Exception\FinalMethodDeclarationException;
use App\Exception\InvalidArgumentNameException;
use App\Exception\InvalidMethodNameDeclarationException;
use PHPUnit\Framework\TestCase;

final class MethodTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = new Method;
		$this->argument = new Argument;
	}

	final public function testIsNotStaticByDefault()
	{
		$this->assertFalse($this->instance->isStatic());
	}

	final public function testGoesStatic()
	{
		$this->instance->makeStatic();
		$this->assertTrue($this->instance->isStatic());
	}

	final public function testRefusesAnonymousArguments()
	{
		$this->argument->setName('');

		$this->expectException(AnonymousArgumentException::class);
		$this->instance->addArgument($this->argument);
	}

	final public function testRefusesInvalidArgumentNames()
	{
		$this->argument->setName('42');

		$this->expectException(InvalidArgumentNameException::class);
		$this->instance->addArgument($this->argument);
	}

	final public function testRefusesDupliacateArgumentNames()
	{
		$this->argument->setName('argument');

		$this->expectException(DuplicateArgumentException::class);
		$this->instance->addArgument($this->argument);
		$this->instance->addArgument($this->argument);
	}

	final public function testHasNoArgumentsByDefault()
	{
		$this->assertCount(0, $this->instance->getArguments());
	}

	final public function testArgumentIsAdded()
	{
		$this->argument->setName('argument');

		$this->instance->addArgument($this->argument);
		$this->assertCount(1, $this->instance->getArguments());
	}

	final public function testDependencyIsAdded()
	{
		$this->argument
			->setName('case')
			->setType(TestCase::class)
		;

		$this->instance->addArgument($this->argument);
		$this->assertTrue($this->instance->hasDependencies());
		$this->assertCount(1, $this->instance->getDependencies());
	}

	final public function testCanNotBeDeclaredIfNameIsMissing()
	{
		$this->expectException(AnonymousMethodException::class);
		$this->instance->getDeclaration();
	}

	final public function testCanNotBeDeclaredIfNameIsInvalid()
	{
		$this->instance->setName('4');
		$this->expectException(InvalidMethodNameDeclarationException::class);
		$this->instance->getDeclaration();
	}

	final public function testCanNotBeDeclaredIfFinal()
	{
		$this->instance
			->setName('test')
			->makeFinal()	
		;
		
		$this->expectException(FinalMethodDeclarationException::class);
		$this->instance->getDeclaration();
	}

	final public function testMinimalDeclaration()
	{
		$this->instance
			->setName('test')
			->setType('string')
		;

		$this->expectOutputString('private function test(): string;');
		$this->instance->getDeclaration();
	}

	final public function testScopeIsUpdatedInDeclaration()
	{
		$this->instance
			->setName('test')
			->setType('string')
			->makePublic()
		;

		$this->expectOutputString('public function test(): string;');
		$this->instance->getDeclaration();
	}
	
	final public function testAbstractAppearsInDeclaration()
	{
		$this->instance
			->setName('test')
			->setType('string')
			->makeAbstract()
		;

		$this->expectOutputString('abstract private function test(): string;');
		$this->instance->getDeclaration();
	}

	final public function testArgumentInDeclaration()
	{
		$this->instance
			->setName('test')
			->setType('string')
			->makeAbstract()
		;

		$this->instance->addArgument((new Argument)
			->setType('int')
			->setName('foo')
		);

		$this->expectOutputString('abstract private function test(int $foo): string;');
		$this->instance->getDeclaration();
	}

	final public function testArgumentsInDeclaration()
	{
		$this->instance
			->setName('test')
			->setType('string')
			->makeAbstract()
		;

		$this->instance->addArgument((new Argument)
			->setType('int')
			->setName('foo')
		);

		$this->instance->addArgument((new Argument)
			->setType(TestCase::class)
			->setName('bar')
		);

		$this->expectOutputString('abstract private function test(int $foo, TestCase $bar): string;');
		$this->instance->getDeclaration();
	}

	final public function testDeclarationWithNoReturnType()
	{
		$this->instance
			->setName('test')
			->makeAbstract()
		;
		
		$this->instance->addArgument((new Argument)
			->setType(TestCase::class)
			->setName('foo')
		);

		$this->expectOutputString('abstract private function test(TestCase $foo);');
		$this->instance->getDeclaration();
	}

	final public function testDeclarationWithComment()
	{
		$this->instance
			->setName('foo')
			->setComment('Does nothing')
			->makeAbstract()
		;

		$expectedOutput = '/**';
		$expectedOutput .= PHP_EOL . ' * Does nothing';
		$expectedOutput .= PHP_EOL . ' */';
		$expectedOutput .= PHP_EOL . 'abstract private function test(TestCase $foo);';
		
		$this->expectOutputString($expectedOutput);
		$this->instance->getDeclaration();
	}
}