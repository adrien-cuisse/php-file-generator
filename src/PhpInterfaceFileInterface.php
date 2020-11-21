<?php

namespace App;

use App\PhpFileInterface;

/**
 * A file containing an interface
 */
interface PhpInterfaceFileInterface extends PhpFileInterface
{
	/**
	 * @return PhpFileInterface[] - the list of interfaces this one extends
	 */
	public function getParents(): array;

	/**
	 * Adds a parent to the interface
	 * 
	 * @param $parent - the parent interface to add
	 * 
	 * @return self
	 */
	public function addParent(PhpInterfaceFileInterface $parent): self;
	
	/**
	 * Checks if the interface extends the given one
	 * 
	 * @param string - the fully qualified interface name (including namespace) to check
	 * 
	 * @return self
	 */
	public function hasParent(string $qualifiedInterfaceName): bool;

	// public function getMethods(): array;
	// public function addMethod(): self;
	// public function hasMethod(): bool;
}