<?php

namespace App\Tests;

use App\Commentable;
use PHPUnit\Framework\TestCase;

final class CommentableTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = $this->getMockForTrait(Commentable::class);
	}

	final public function testDetectsComment()
	{
		$this->instance->setComment('');
		$this->assertFalse($this->instance->hasComment());

		$this->instance->setComment(' ');
		$this->assertFalse($this->instance->hasComment());

		$this->instance->setComment('test');
		$this->assertTrue($this->instance->hasComment());
	}
}