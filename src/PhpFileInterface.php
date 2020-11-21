<?php

namespace App;

use App\Exception\MissingDependencyException;

/**
 * A php file containing a single subject, being a class/interface/trait
 */
interface PhpFileInterface
{
	/**
	 * @return string - the fully qualified name of the subject
	 * eg: Symfony\Bundle\FrameworkBundle\Controller\AbstractController
	 * eg: App\SomeInterface
	 */
	public function getQualifiedSubject(): string;

	/**
	 * @return string - the subject defined in the file
	 * eg: ServerRequestInterface
	 * eg: SomeInterface
	 */
	public function getSubject(): string;

	/**
	 * @return bool - is it a source of the current project or is it in vendor ?
	 */
	public function isInternal(): bool;

	/**
	 * @return string - the path to the root directory of the project
	 * eg: /some/directory/my-project
	 */
	public function getRootDirectoryPath(): string;

	/**
	 * @return string - the path from the root directory to the file
	 * eg: src/Controller/MyController.php
	 */
	public function getRelativePath(): string;

	/**
	 * @return string - the path to the file from the filesystem root
	 * eg: /some/directory/my-project/src/Controller/MyController.php
	 */
	public function getAbsolutePath(): string;

	/**
	 * @return string - the namespace of the file
	 * eg: Symfony\Bundle\FrameworkBundle\Controller\AbstractController
	 */
	public function getNamespace(): string;

	/**
	 * @return string - the root namespace of the file
	 * eg: Symfony
	 */
	public function getRootNamespace(): string;

	/**
	 * @return string - the name of file, without its path
	 * eg: MyController.php
	 */
	public function getName(): string;

	/**
	 * @return PhpFileInterface[] - list of files required for this one
	 */
	public function getDependencies(): array;

	/**
	 * @return PhpFileInterface - the requested dependency
	 * 
	 * @throws MissingDependencyException - if it wasn't found in the container
	 */
	public function getDependency(string $classname): PhpFileInterface;

	/**
	 * Checks if the file has the given dependency
	 * 
	 * @param PhpFileInterface - the dependency to check
	 * 
	 * @return bool - true if the given file is a dependency, false otherwise
	 */
	public function hasDependency(string $classname): bool;
	
	/**
	 * Adds a dependency to the file
	 * 
	 * @param PhpFileInterface - the dependency to add
	 * 
	 * @return self
	 */
	public function addDependency(PhpFileInterface $dependency): self;

	/**
	 * Writes the file to the disk
	 * Internal dependencies are writen as well and missing directories created
	 */
	public function write(): self;
}