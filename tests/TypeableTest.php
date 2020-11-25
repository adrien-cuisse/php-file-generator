<?php

namespace App\Tests;

use App\Typeable;
use App\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

final class TypeableTest extends TestCase
{	
	final public function test_litteral_types_are_applied()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType('string');
		
		// then
		$this->assertEquals('string', $typeable->getCanonicalType());
	}

	final public function test_namespace_is_extracted_from_canonical_type()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType(TestCase::class);
		
		// then
		$this->assertEquals('TestCase', $typeable->getCanonicalType());
	}

	final public function test_qualified_type_is_set()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType(TestCase::class);
		
		// then
		$this->assertEquals(TestCase::class, $typeable->getQualifiedType());
	}

	final public function test_rejects_invalid_litteral_types()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		
		// then
		$this->expectException(InvalidTypeException::class);
		$typeable->setType('42');
	}

	final public function test_rejects_invalid_namespaced_types()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		
		// then
		$this->expectException(InvalidTypeException::class);
		$typeable->setType('App\\Test\\42\\Foo');
	}

	final public function test_detects_types()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType('string');
		
		// then
		$this->assertTrue($typeable->isTyped());
	}

	final public function test_detects_namespace()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType(TestCase::class);
		
		// then
		$this->assertTrue($typeable->isNamespaced());
	}

	final public function test_adds_dependencies()
	{
		// given
		$typeable = $this->getMockForTrait(Typeable::class);
		
		// when
		$typeable->setType(TestCase::class);
		
		// then
		$this->assertCount(1, $typeable->getDependencies());
	}
}