<?php

namespace App\Tests;

use App\Scopeable;
use App\Exception\InvalidNameException;
use PHPUnit\Framework\TestCase;

final class ScopeableTest extends TestCase
{	
	final public function test_goes_public()
	{
		// given
		$scopeable = $this->getMockForTrait(Scopeable::class);
		
		// when
		$scopeable->makeProtected();
		$scopeable->makePublic();
		
		// then
		$this->assertEquals('public', $scopeable->getScope());
	}

	final public function test_goes_protected()
	{
		// given
		$scopeable = $this->getMockForTrait(Scopeable::class);
		
		// when
		$scopeable->makePrivate();
		$scopeable->makeProtected();
		
		// then
		$this->assertEquals('protected', $scopeable->getScope());
	}

	final public function test_goes_private()
	{
		// given
		$scopeable = $this->getMockForTrait(Scopeable::class);
		
		// when
		$scopeable->makePublic();
		$scopeable->makePrivate();

		// then
		$this->assertEquals('private', $scopeable->getScope());
	}
}