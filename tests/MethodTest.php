<?php

namespace App\Tests;

use App\Argument;
use App\ArgumentInterface;
use App\PhpFileInterface;
use App\Method;
use App\MethodInterface;
use App\Exception\AnonymousArgumentException;
use App\Exception\MisnamedArgumentException;
use App\Exception\DuplicateArgumentException;
use PHPUnit\Framework\TestCase;

final class MethodTest extends TestCase
{
	/**
	 * @var MethodInterface - the instance to test
	 */
	private MethodInterface $method;

	/**
	 * @var ArgumentInterface - first argument
	 */
	private ArgumentInterface $firstArgument;

	/**
	 * @var ArgumentInterface - second argument
	 */
	private ArgumentInterface $secondArgument;
	
	public function setUp(): void
	{
		$this->method = new Method;
	}

	public function testAcceptsOnlyNamedParameters()
	{
		$anonymousArgument = new Argument;

		$this->expectException(AnonymousArgumentException::class);

		$this->method
			->addArgument($anonymousArgument)
		;
	}

	public function testDoesNotAcceptDuplicateArgument()
	{
		$firstArgument = (new Argument)
			->setName('argument')
		;

		$secondArgument = (new Argument)
			->setName('argument')
		;

		$this->expectException(DuplicateArgumentException::class);
		
		$this->method
			->addArgument($firstArgument)
			->addArgument($secondArgument)
		;
	}

	public function testRefusesMisnamedArguments()
	{
		$misnamedArgument = (new Argument)
			->setName('invalid name')
		;

		$this->expectException(MisnamedArgumentException::class);

		$this->method
			->addArgument($misnamedArgument)
		;
	}

	public function testExtractsNamespaceFromType()
	{
		// TODO: refactor using trait DependantTrait, NameableTrait, ScopableTrait, ModifiableTrait

		$namespacedArgument = (new Argument)
			->setName('file')
			->setType(PhpFileInterface::class)
		;

		$this->method->addArgument($namespacedArgument);
		$this->assertNotEquals(PhpFileInterface::class, $namespacedArgument->getType());
	
		$litteralArgument = (new Argument)
			->setName('count')
			->setType('int')
		;

		$this->method->addArgument($litteralArgument);
		$this->assertEquals('int', $litteralArgument->getType());
	}

	// public function testAddsTypeToDependencies()
	// {
	// 	// TODO: refactor using trait DependantTrait, NameableTrait, ScopableTrait, ModifiableTrait

	// 	// checks $method->dependencies after addArgument
	// }

	public function testModifierOverride()
	{
		$this->assertNull($this->method->getModifier());
		$this->assertFalse($this->method->isAbstract());
		$this->assertFalse($this->method->isFinal());

		$this->method->makeAbstract();
		$this->assertEquals('abstract', $this->method->getModifier());
		$this->assertTrue($this->method->isAbstract());
		$this->assertFalse($this->method->isFinal());
		
		$this->method->makeFinal();
		$this->assertEquals('final', $this->method->getModifier());
		$this->assertFalse($this->method->isAbstract());
		$this->assertTrue($this->method->isFinal());

		$this->method->makeAbstract();
		$this->assertEquals('abstract', $this->method->getModifier());
		$this->assertTrue($this->method->isAbstract());
		$this->assertFalse($this->method->isFinal());
	}

	public function testScopeOverride()
	{
		// should be private by default, for safety
		$this->assertEquals('private', $this->method->getScope());
		$this->assertNotEquals('protected', $this->method->getScope());
		$this->assertNotEquals('public', $this->method->getScope());
		
		$this->method->makePublic();
		$this->assertNotEquals('private', $this->method->getScope());
		$this->assertNotEquals('protected', $this->method->getScope());
		$this->assertEquals('public', $this->method->getScope());
		
		$this->method->makeProtected();
		$this->assertNotEquals('private', $this->method->getScope());
		$this->assertEquals('protected', $this->method->getScope());
		$this->assertNotEquals('public', $this->method->getScope());
		
		$this->method->makePrivate();
		$this->assertEquals('private', $this->method->getScope());
		$this->assertNotEquals('protected', $this->method->getScope());
		$this->assertNotEquals('public', $this->method->getScope());
	}

	// public function testWriteDeclaration()
	// {
	// 	$this->method
	// 		->setName('execute')
	// 		->makeFinal()
	// 		->makePublic()
	// 		->addArgument($this->firstArgument)
	// 		->addArgument($this->secondArgument)
	// 	;

	// 	$this->expectOutputString('test');
	// 	$this->method->writeDeclaration();
	// }
}