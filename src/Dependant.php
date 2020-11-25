<?php

namespace App;

use App\DependantInterface;

trait Dependant
{
	/**
	 * @var array - the list of dependencies
	 */
	private array $dependencies = [];

	/**
	 * @see DependantInterface
	 */
	final public function getDependencies(): array
	{
		return $this->dependencies;
	}

	/**
	 * @see DependantInterface
	 */
	final public function addDependency(string $dependency): self
	{
		return $this->addDependencies([$dependency]);
	}

	/**
	 * @see DependantInterface
	 */
	final public function addDependencies(array $dependencies): self
	{
		foreach ($dependencies as $dependency) {
			$this->dependencies[] = $dependency;
		}

		$this->dependencies = array_unique($this->dependencies);

		return $this;
	}
}