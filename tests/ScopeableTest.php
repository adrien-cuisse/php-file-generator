<?php

namespace App\Tests;

use App\Scopeable;
use PHPUnit\Framework\TestCase;

final class ScopeableTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Scopeable::class);
	}

	final public function testScopeIsUpdated()
	{
		$scopes = [];

		$this->instance->makePublic();
		$scopes[] = $this->instance->getScope();
		
		$this->instance->makeProtected();
		$scopes[] = $this->instance->getScope();
		
		$this->instance->makePrivate();
		$scopes[] = $this->instance->getScope();
		
		$scopes = array_unique($scopes);

		$this->assertCount(3, $scopes);
	}
}