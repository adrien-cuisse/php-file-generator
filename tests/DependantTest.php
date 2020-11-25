<?php

namespace App\Tests;

use App\Dependant;
use PHPUnit\Framework\TestCase;

final class DependantTest extends TestCase
{	
	final public function test_dependency_is_added()
	{
		// given
		$dependant = $this->getMockForTrait(Dependant::class);
		
		// when
		$dependant->addDependency(TestCase::class);
		
		// then
		$this->assertCount(1, $dependant->getDependencies());
	}

	final public function test_duplicate_dependencies_are_not_added()
	{
		// given
		$dependant = $this->getMockForTrait(Dependant::class);
		
		// when
		$dependant->addDependency(TestCase::class);
		$dependant->addDependency(TestCase::class);
		
		// then
		$this->assertCount(1, $dependant->getDependencies());
	}

	final public function test_all_dependencies_are_added()
	{
		// given
		$dependant = $this->getMockForTrait(Dependant::class);
		
		// when
		$dependant->addDependencies([TestCase::class, DependantInterface::class]);
		
		// then
		$this->assertCount(2, $dependant->getDependencies());
	}
}