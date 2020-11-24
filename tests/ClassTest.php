<?php

namespace App\Tests;

use App\_Class;
use App\Method;
use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
	final public function setUp(): void
	{
		$this->instance = new _Class;
		$this->method = new Method;

		// TODO:
		// adding methods should also add its dependencies
		// should not be able to add anonymous method, or misnamed
		// adding an abstract method should make the class abstract
	}

	public function testMethodIsAdded()
	{
		$this->method->setName('test');
		$this->instance->addMethod($this->method);
		$this->assertCount(1, $this->instance->getMethods());
	}
}