<?php

namespace App\Tests;

use App\Expandable;
use PHPUnit\Framework\TestCase;

final class ExpandableTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Expandable::class);
	}

	final public function testHasNoExpandabilityIfNotSpecified()
	{
		$this->assertFalse($this->instance->hasExpandability());
	}

	final public function testBecomesAbstract()
	{
		$this->instance->makeAbstract();
		$this->assertTrue($this->instance->hasExpandability());
		$this->assertEquals('abstract', $this->instance->getExpandability());
	}

	final public function testBecomesFinal()
	{
		$this->instance->makeFinal();
		$this->assertTrue($this->instance->hasExpandability());
		$this->assertEquals('final', $this->instance->getExpandability());
	}
}