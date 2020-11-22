<?php

namespace App;

use App\Commentable;
use App\Dependant;
use App\Expandable;
use App\Nameable;
use App\Scopeable;
use App\Typeable;
use App\Exception\AnonymousArgumentException;
use App\Exception\AnonymousMethodException;
use App\Exception\DuplicateArgumentException;
use App\Exception\FinalMethodDeclarationException;
use App\Exception\InvalidArgumentNameException;
use App\Exception\InvalidMethodNameDeclarationException;

final class Method implements MethodInterface
{
	use Commentable;
	use Dependant;
	use Expandable;
	use Nameable;
	use Scopeable;
	use Typeable;

	/**
	 * @var bool - is the method static ?
	 */
	private bool $isStatic = false;

	/**
	 * @var ArgumentInterface[] - the list of arguments of the method
	 */
	private array $arguments = [];

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
	final public function getArguments(): array
	{
		return $this->arguments;
	}

	/**
	 * @see MethodInterface
	 */
	final public function addArgument(ArgumentInterface $argument): self
	{
		if (! $argument->isNamed()) {
			throw new AnonymousArgumentException($this->name);
		} else if (! $argument->hasValidName()) {
			throw new InvalidArgumentNameException($this->name, $argument->getName());
		} else if ($this->hasAlreadyArgumentName($argument)) {
			throw new DuplicateArgumentException($this->name, $argument->getName());
		}
		
		$this->addDependency($argument);
		// TODO: if argument is typed and namespace, add it to dependencies (Dependant)
		
		$this->arguments[] = $argument;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDeclaration(): self
	{
		if (! $this->isNamed()) {
			throw new AnonymousMethodException('declaration');
		} else if (! $this->hasValidName()) {
			throw new InvalidMethodNameDeclarationException($this->name);
		} else if ($this->isFinal()) {
			throw new FinalMethodDeclarationException($this->name);
		}

		$buffer = $this->getCanonicalDeclaration();

		$buffer .= ';';

		echo $buffer;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDefinition(): self
	{

		return $this;
	}

	/**
	 * @param ArgumentInterface - the argument to check
	 * 
	 * @return bool - true if an argument with the same was already added
	 */
	final private function hasAlreadyArgumentName(ArgumentInterface $argument): bool
	{
		foreach ($this->arguments as $storedArgument) {
			if ($storedArgument->getName() === $argument->getName()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string - the canonical declaration string, without semi-colon
	 * eg: protected function bar()
	 * eg: abstract public function foo(string $test): bool
	 * eg: private function handle(Request $bar, int $id): Response
	 */
	final private function getCanonicalDeclaration(): string
	{
		$buffer = sprintf(
			'%s%s function %s(',
			$this->isAbstract() ? 'abstract ' : '',
			$this->scope,
			$this->name
		);
		
		$comma = false;
		foreach ($this->arguments as $argument) {
			if ($comma) {
				$buffer .= ', ';
			}

			$buffer .= $argument->getCanonicalType() . ' $' . $argument->getName();
			$comma = true;
		}

		$buffer .= ')';

		if ($this->isTyped()) {
			$buffer .= ': ' . $this->getCanonicalType();
		}

		return $buffer;
	}
}