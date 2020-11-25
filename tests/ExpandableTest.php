<?php

namespace App\Tests;

use App\Expandable;
use PHPUnit\Framework\TestCase;

final class ExpandableTest extends TestCase
{
	final public function test_has_no_expandability_by_default()
	{
		// given
		$expandable = $this->getMockForTrait(Expandable::class);

		// when
		
		// then
		$this->assertFalse($expandable->hasExpandability());
	}

	final public function test_detects_expandability()
	{
		// given
		$expandable = $this->getMockForTrait(Expandable::class);

		// when
		$expandable->makeAbstract();
		
		// then
		$this->assertTrue($expandable->hasExpandability());
	}

	final public function test_goes_abstract()
	{
		// given
		$expandable = $this->getMockForTrait(Expandable::class);

		// when
		$expandable->makeAbstract();
		
		// then
		$this->assertTrue($expandable->isAbstract());
	}

	final public function test_goes_final()
	{
		// given
		$expandable = $this->getMockForTrait(Expandable::class);

		// when
		$expandable->makeFinal();
		
		// then
		$this->assertTrue($expandable->isFinal());
	}
}