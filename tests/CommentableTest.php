<?php

namespace App\Tests;

use App\Commentable;
use App\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

final class CommentableTest extends TestCase
{	
	final public function test_comment_is_set()
	{
		// given
		$commentable = $this->getMockForTrait(Commentable::class);
		
		// when
		$commentable->setComment('some comment');
		
		// then
		$this->assertEquals('some comment', $commentable->getComment());
	}

	final public function test_detects_comment()
	{
		// given
		$commentable = $this->getMockForTrait(Commentable::class);
		
		// when
		$commentable->setComment('some comment');
		
		// then
		$this->assertTrue($commentable->hasComment());
	}
}