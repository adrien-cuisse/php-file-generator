<?php

namespace App;

use App\TypeableInterface;

/**
 * Provides a list of dependencies (types to include)
 */
interface DependantInterface
{
	/**
	 * @return TypeableInterface[] - the list of types it needs
	 */
	public function getDependencies(): array;

	/**
	 * @param TypeableInterface - the type to add
	 */
	public function addDependency(TypeableInterface $dependency): self;

	/**
	 * @return bool - true if it has dependencies, false otherwise
	 */
	public function hasDependencies(): bool;
}