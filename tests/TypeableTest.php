<?php

namespace App\Tests;

use App\Typeable;
use PHPUnit\Framework\TestCase;

final class TypeableTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Typeable::class);
	}

	final public function testHasNoTypeIfNotSpecified()
	{
		$this->assertFalse($this->instance->isTyped());
		
		$this->instance->setType('bool');
		$this->assertTrue($this->instance->isTyped());
	}

	final public function testDetectsNamespace()
	{
		$this->instance->setType(Typeable::class);
		$this->assertTrue($this->instance->isNamespaced());
		$this->assertFalse($this->instance->isCanonical());

		$this->instance->setType('int');
		$this->assertFalse($this->instance->isNamespaced());
		$this->assertTrue($this->instance->isCanonical());
	} 

	final public function testNamespaceIsExtracted()
	{
		$this->instance->setType(Typeable::class);
		$this->assertEquals(Typeable::class, $this->instance->getQualifiedType());
		$this->assertEquals('Typeable', $this->instance->getCanonicalType());
	}
}