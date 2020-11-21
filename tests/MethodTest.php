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

		$this->firstArgument = (new Argument)
			->setType(string::class)
			->setName('name')
			->setDescription('the name')
		;

		$this->secondArgument = (new Argument)
			->setType(FileInterface::class)
			->setName('argument')
			->setDescription('the argument')
		;
	}

	public function testAcceptsOnlyNamedParameters()
	{
		$this->firstArgument
			->method('getName')
			->willReturn('')
		;

		$this->expectException(AnonymousArgumentException::class);

		$this->method
			->addArgument($this->firstArgument)
		;
	}

	public function testDoesNotAcceptDuplicateArgument()
	{
		$this->firstArgument
			->method('getName')
			->willReturn('argument')
		;

		$this->expectException(DuplicateArgumentException::class);
		
		$this->method
			->addArgument($this->firstArgument)
			->addArgument($this->firstArgument)
		;
	}

	public function testRefusesMisnamedArguments()
	{
		$this->firstArgument
			->method('getName')
			->willReturn('some argument')
		;

		$this->expectException(MisnamedArgumentException::class);

		$this->method
			->addArgument($this->firstArgument)
		;
	}

	public function testExtractsNamespaceFromType()
	{
		// TODO: refactor using trait DependantTrait, NameableTrait, ScopableTrait, ModifiableTrait

		// $this->method->addArgument($secondArgument);
		// $this->assertNotEquals(PhpFileInterface::class, $this->argument->getType());
	}

	public function testAddsTypeToDependencies()
	{
		// TODO: refactor using trait DependantTrait, NameableTrait, ScopableTrait, ModifiableTrait

		// checks $method->dependencies after addArgument
	}

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

	public function testWriteDeclaration()
	{
		$this->method
			->setName('execute')
			->makeFinal()
			->makePublic()
			->addArgument($this->firstArgument)
			->addArgument($this->secondArgument)
		;

		$this->expectOutputString('test');
		$this->method->writeDeclaration();
	}
}