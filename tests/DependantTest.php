<?php

namespace App\Tests;

use App\Dependant;
use App\TypeableInterface;
use PHPUnit\Framework\TestCase;

final class DependantTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Dependant::class);
		$this->dependency = $this->createMock(TypeableInterface::class);
	}

	final public function testHasNoDependenciesIfNotSpecified()
	{
		$this->assertFalse($this->instance->hasDependencies());
		$this->assertCount(0, $this->instance->getDependencies());
	}

	final public function testMissingTypesAreNotDependencies()
	{
		$this->dependency
			->method('isTyped')
			->willReturn(false)
		;

		$this->instance->addDependency($this->dependency);
		$this->assertCount(0, $this->instance->getDependencies());
	}

	final public function testCanonicalTypesAreNotDependencies()
	{
		$this->dependency
			->method('isTyped')
			->willReturn(true)
		;

		$this->dependency
			->method('isNamespaced')
			->willReturn(false)
		;

		$this->instance->addDependency($this->dependency);
		$this->assertCount(0, $this->instance->getDependencies());
	}

	final public function testDependencyIsAdded()
	{
		$this->dependency
			->method('isTyped')
			->willReturn(true)
		;
	
		$this->dependency
			->method('isNamespaced')
			->willReturn(true)
		;

		$this->dependency
			->method('getQualifiedType')
			->willReturn(TestCase::class)
		;
			
		$this->instance->addDependency($this->dependency);
		$this->assertCount(1, $this->instance->getDependencies());	
	}

	final public function testDoesNotAddDuplicateTypes()
	{
		$this->dependency
			->method('isTyped')
			->willReturn(true)
		;

		$this->dependency
			->method('isNamespaced')
			->willReturn(true)
		;

		$this->dependency
			->method('getQualifiedType')
			->willReturn(TestCase::class)
		;

		$this->instance->addDependency($this->dependency);
		$this->instance->addDependency($this->dependency);
		$this->assertCount(1, $this->instance->getDependencies());	
	}
}