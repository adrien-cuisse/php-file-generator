<?php

namespace App;

use App\Commentable;
use App\Expandable;
use App\Nameable;
use App\Scopeable;
use App\Typeable;
use App\Exception\AbstractMethodDefinitionException;
use App\Exception\DuplicateArgumentException;

final class Method implements MethodInterface
{
	use Commentable;
	use Expandable;
	use Nameable;
	use Scopeable;
	use Typeable;

	/**
	 * @var string - fluent return-type
	 */
	public const FLUENT = 'self';

	/** 
	 * @var ArgumentInterface[] - the list of arguments of the method
	 */
	private array $arguments = [];

	/**
	 * @var bool - is the method static ?
	 */
	private bool $isStatic = false;

	/**
	 * @see MethodInterface
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
			throw new DuplicateArgumentException($this->getName(), $argument->getName());
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
	final public function makeStatic(): self
	{
		$this->isStatic = true;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	final public function isStatic(): bool
	{
		return $this->isStatic;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDocBlock(): string
	{
		$docBlock = '/**' . PHP_EOL;

		if ($this->hasComment()) {
			$docBlock .= ' * ' . $this->getComment() . PHP_EOL;
		}

		if ($this->hasArguments()) {
			if ($this->hasComment()) {
				$docBlock .= ' *' . PHP_EOL; // blank line between self comment and properties
			}

			foreach($this->arguments as $argument) {
				$docBlock .= ' * @param ' . $argument->getCanonicalType();
				if ($argument->hasComment()) {
					$docBlock .= ' - ' . $argument->getComment();
				}
				$docBlock .= PHP_EOL;
			}
		}

		$docBlock .= ' */';
		
		return $docBlock;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDeclaration(): string
	{
		return $this->getCanonicalDeclaration() . ';';
	}

	/**
	 * @see MethodInterface
	 */
	public function getDefinition(): string
	{
		if ($this->isAbstract()) {
			throw new AbstractMethodDefinitionException($this->getName());
		}

		$definition = $this->getCanonicalDeclaration() . PHP_EOL;
		$definition .= '{' . PHP_EOL;
		
		if ($this->getCanonicalType() === self::FLUENT) {
			$definition .= "\treturn \$this;" . PHP_EOL;
		} else {
			$definition .= PHP_EOL;
		}
		
		$definition .= '}';

		return $definition;
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

	/**
	 * @return string - the declaration string of the method, without trailing semi-colon
	 */
	final private function getCanonicalDeclaration(): string
	{
		$declaration = '';

		if ($this->hasExpandability()) {
			$declaration .= $this->getExpandability() . ' '; 
		}

		$declaration .= $this->getScope();
		
		if ($this->isStatic) {
			$declaration .= ' static';
		}
		
		$declaration .= ' function ' . $this->getName() . '(';
		
		foreach ($this->arguments as $count => $argument) {
			if ($count > 0) {
				$declaration .= ', ';
			}
			$declaration .= $argument->getCanonicalType() . ' $' . $argument->getName();
		}
		
		$declaration .= ')';

		if ($this->isTyped()) {
			$declaration .= ': ' . $this->getCanonicalType();
		}

		return $declaration;
	}
}