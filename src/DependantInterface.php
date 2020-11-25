<?php

namespace App;

/**
 * Provides a list of namespaced type-dependencies
 */
interface DependantInterface
{
	/**
	 * @return string[] - the list of namespaced typed-dependencies
	 */
	public function getDependencies(): array;

	/**
	 * @param string - the dependency to add
	 * 
	 * @return self
	 */
	public function addDependency(string $dependency): self;

	/**
	 * @param string[] - list of dependencies to add to the current ones
	 * 
	 * @return self
	 */
	public function addDependencies(array $dependencies): self;
}