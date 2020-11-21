<?php

namespace App\Tests;

use App\PhpInterfaceFile;
use App\PhpInterfaceFileInterface;
use PHPUnit\Framework\TestCase;

final class PhpInterfaceFileTest extends TestCase
{
	/**
	 * @var PhpInterfaceFile - instance to run tests on
	 */
	private PhpInterfaceFile $file;

	/**
	 * @var PhpInterfaceFile - instance to run tests on
	 */
	private PhpInterfaceFile $vendorFile;

	public function setUp(): void
	{
		$this->file = new PhpInterfaceFile('App\\Controller\\FooController');
		$this->vendorFile = new PhpInterfaceFile('Psr\\Http\\Message\\ServerRequestInterface');
	}

	public function testAddsParent()
	{
		$this->file->addParent($this->vendorFile);
		$this->assertCount(1, $this->file->getParents());
	}

	public function testDetectsParent()
	{
		$this->assertFalse($this->file->hasParent($this->vendorFile->getQualifiedSubject()));
		$this->file->addParent($this->vendorFile);
		$this->assertTrue($this->file->hasParent($this->vendorFile->getQualifiedSubject()));
	}

	public function testDoesntAddDuplicateParent()
	{
		$this->file->addParent($this->vendorFile);
		$this->file->addParent($this->vendorFile);
		$this->assertCount(1, $this->file->getParents());
	}

	public function testParentIsAddedToDependencies()
	{
		$this->file->addParent($this->vendorFile);
		$this->assertCount(1, $this->file->getDependencies());
	}

	// public function testWrite()
	// {
	// 	$this->file->addParent($this->vendorFile);
	// 	$this->file->write();
	// }
}