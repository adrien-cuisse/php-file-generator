<?php

namespace App\Tests;

use App\Nameable;
use App\Exception\InvalidNameException;
use PHPUnit\Framework\TestCase;

final class NameableTest extends TestCase
{	
	final public function test_rejects_invalid_names()
	{
		// given
		$nameable = $this->getMockForTrait(Nameable::class);
		
		// when
		
		// then
		$this->expectException(InvalidNameException::class);
		$nameable->setName('3');
	}

	final public function test_name_is_set()
	{
		// given
		$nameable = $this->getMockForTrait(Nameable::class);
		
		// when
		$nameable->setName('foo');
		
		// then
		$this->assertEquals('foo', $nameable->getName());
	}

	final public function test_detects_name()
	{
		// given
		$nameable = $this->getMockForTrait(Nameable::class);
		
		// when
		$nameable->setName('foo');
		
		// then
		$this->assertTrue($nameable->isNamed());
	}
}