<?php

namespace App\Tests;

use App\Nameable;
use PHPUnit\Framework\TestCase;

final class NameableTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Nameable::class);
	}

	final public function testDetectsName()
	{
		$this->assertFalse($this->instance->isNamed());

		$this->instance->setName(' ');
		$this->assertFalse($this->instance->isNamed());

		// name has been provided, even if invalid
		$this->instance->setName('3');
		$this->assertTrue($this->instance->isNamed());
	}

	final public function testNamesCantBeEmpty()
	{
		$this->instance->setName('');
		$this->assertFalse($this->instance->hasValidName());

		$this->instance->setName('test');
		$this->assertTrue($this->instance->hasValidName());
	}

	final public function testNamesCantStartWithNumber()
	{
		$this->instance->setName('3');
		$this->assertFalse($this->instance->hasValidName());
		
		$this->instance->setName('42');
		$this->assertFalse($this->instance->hasValidName());

		$this->instance->setName('a9');
		$this->assertTrue($this->instance->hasValidName());
	}

	final function testNamesCantHaveSymbols()
	{
		$this->instance->setName('a9#');
		$this->assertFalse($this->instance->hasValidName());

		$this->instance->setName('a9$');
		$this->assertFalse($this->instance->hasValidName());
	}

	final public function testNamesAllowUnderscore()
	{		
		$this->instance->setName('_9');
		$this->assertTrue($this->instance->hasValidName());
	
		$this->instance->setName('_');
		$this->assertTrue($this->instance->hasValidName());
		
		$this->instance->setName('a9_');
		$this->assertTrue($this->instance->hasValidName());
	}
}