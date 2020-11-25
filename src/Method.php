<?php

namespace App;

use App\Commentable;
use App\Nameable;
use App\Scopeable;
use App\Typeable;
use App\Exception\DuplicateArgumentException;

final class Method implements MethodInterface
{
	use Commentable;
	use Nameable;
	use Scopeable;
	use Typeable;

	/** 
	 * @var ArgumentInterface[] - the list of arguments of the method
	 */
	private array $arguments = [];

	/**
	 * @param string - the name of the method
	 */
	final public function __construct(string $name)
	{
		$this->setName($name);
	}

	/**
	 * @see MethodInterface
	 */
	final public function getArguments(): array
	{
		return $this->arguments;
	}

	/**
	 * @see MethodInterface
	 */
	final public function addArgument(ArgumentInterface $argument): self
	{
		if ($this->hasArgument($argument)) {
			throw new DuplicateArgumentException($this->name, $argument->getName());
		}

		$this->arguments[] = $argument;

		$this->addDependencies($argument->getDependencies());

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	final public function hasArguments(): bool
	{
		return count($this->arguments) > 0;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDeclaration(): string
	{
		// checkpoint
		
		return '';
	}

	/**
	 * @param ArgumentInterface - the argument to check
	 * 
	 * @return bool - true if the method contains an argument named like the given one, false otherwise
	 */
	final private function hasArgument(ArgumentInterface $argument): bool
	{
		foreach ($this->arguments as $currentArgument) {
			if ($currentArgument->getName() === $argument->getName()) {
				return true;
			}
		}

		return false;
	}
}