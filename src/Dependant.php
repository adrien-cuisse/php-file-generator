<?php

namespace App;

use App\TypeableInterface;

trait Dependant
{
	/**
	 * @var TypeableInterface[] - the list of types it needs
	 */
	private array $dependencies = [];

	/**
	 * @see DependantInterface
	 */
	public function getDependencies(): array
	{
		return $this->dependencies;
	}

	/**
	 * @see DependantInterface
	 */
	public function addDependency(TypeableInterface $dependency): self
	{
		if ($dependency->isTyped() && $dependency->isNamespaced()) {
			$type = $dependency->getQualifiedType();
			if (! $this->hasDependency($type)) {
				$this->dependencies[] = $type; 
			}
		}
		
		return $this;
	}

	/**
	 * @see DependantInterface
	 */
	public function hasDependencies(): bool
	{
		return 0 !== count($this->dependencies);
	}

	/**
	 * Checks if a dependency is already stored
	 * 
	 * @param string - the dependency to check
	 * 
	 * @return bool - true if the dependency is already stored, false otherwise
	 */
	final private function hasDependency(string $type): bool
	{
		return in_array($type, $this->dependencies);
	}
}