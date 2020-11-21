<?php

namespace App\Tests;

use App\PhpFile;
use App\PhpFileInterface;
use PHPUnit\Framework\TestCase;

final class PhpFileTest extends TestCase
{
	/**
	 * @var PhpFile - instance to run tests on
	 */
	private PhpFile $file;

	/**
	 * @var PhpFile - instance to run tests on
	 */
	private PhpFile $vendorFile;

	public function setUp(): void
	{
		// mocks are an easy way to instantiate an abstract class
		$this->file = $this->getMockBuilder(PhpFile::class)
			->setConstructorArgs(['App\\Controller\\FooController'])
			->getMockForAbstractClass()
		;
		$this->vendorFile = $this->getMockBuilder(PhpFile::class)
			->setConstructorArgs(['Symfony\Bundle\FrameworkBundle\Controller\AbstractController'])
			->getMockForAbstractClass()
		;
	}

	public function testComputesSubjectNameCorrectly()
	{
		$this->assertEquals('FooController', $this->file->getSubject());
	}

	public function testDetectsVendorFiles()
	{
		$this->assertTrue($this->file->isInternal());
		$this->assertFalse($this->vendorFile->isInternal());
	}

	public function testComputesRootDirectoryPathCorrectly()
	{
		$this->assertStringEndsWith('php-file-generator', $this->file->getRootDirectoryPath());
		$this->assertEquals(dirname(__DIR__), $this->file->getRootDirectoryPath());
	}

	public function testComputesRelativePathCorrectly()
	{
		$this->assertStringStartsWith('src', $this->file->getRelativePath());
		$this->assertEquals('src/Controller/FooController.php', $this->file->getRelativePath());
	}

	public function testComputesAbsolutePathCorrectly()
	{
		$absolutePath = dirname(__DIR__) 
			. DIRECTORY_SEPARATOR 
			. implode(DIRECTORY_SEPARATOR, ['src', 'Controller', 'FooController'])
			. '.php'
		;

		$this->assertEquals(
			$absolutePath,
			$this->file->getAbsolutePath()
		);
	}

	public function testComputesNamespaceCorrectly()
	{
		$this->assertStringStartsWith('App', $this->file->getNamespace());
		$this->assertEquals('App\\Controller', $this->file->getNamespace());
	}

	public function testComputesRootNamespaceCorrectly()
	{
		$this->assertEquals('App', $this->file->getRootNamespace());
	}

	public function testComputesFileNameCorrectly()
	{
		$this->assertStringEndsWith('.php', $this->file->getName());
		$this->assertEquals('FooController.php', $this->file->getName());
	}

	public function testAddsDependency()
	{
		$this->file->addDependency($this->vendorFile);
		$this->assertCount(1, $this->file->getDependencies());
	}

	public function testDetectsDependency()
	{
		$this->assertFalse($this->file->hasDependency($this->vendorFile->getQualifiedSubject()));
		$this->file->addDependency($this->vendorFile);
		$this->assertTrue($this->file->hasDependency($this->vendorFile->getQualifiedSubject()));
	}

	public function testDoesntAddDuplicateDependencies()
	{
		$this->file->addDependency($this->vendorFile);
		$this->file->addDependency($this->vendorFile);
		$this->assertCount(1, $this->file->getDependencies());
	}

	// public function testCreatesMissingDirectory()
	// {
	// 	// absolute path to missing directories
	// 	$directoriesPath = [];

	// 	// list of directories to create
	// 	$missingDirectories = explode(DIRECTORY_SEPARATOR, $this->file->getRelativePath());
	// 	$missingDirectories = array_slice($missingDirectories, 1, count($missingDirectories) - 2);
		
	// 	// where we are right now
	// 	$currentPath = $this->file->getRootDirectoryPath() . DIRECTORY_SEPARATOR . 'src';

	// 	// check if inexistant path has been provided, for safety
	// 	foreach ($missingDirectories as $missingDirectory) {
	// 		$currentPath .= DIRECTORY_SEPARATOR . $missingDirectory;
	// 		$this->assertDirectoryDoesNotExist(
	// 			$currentPath,
	// 			'Warning: specified existing directory, cannot test creation'
	// 		);
	// 		$directoriesPath[] = $currentPath;
	// 	}

	// 	$this->file->createDirectories();
		
	// 	// check creation
	// 	foreach ($directoriesPath as $createdDirectory) {
	// 		$this->assertDirectoryExists($createdDirectory, 'Directory was not created');
	// 	}

	// 	// cleanup
	// 	foreach (array_reverse($directoriesPath) as $directoryToDelete) {
	// 		rmdir($directoryToDelete);
	// 		$this->assertDirectoryDoesNotExist($directoryToDelete, 'Directory was not deleted');
	// 	}
	// }

	// public function testDoesNotCreatesExternalDirectory()
	// {
	// 	// how to check that mkdir has not been called ?
	// }
}