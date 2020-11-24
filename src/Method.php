<?php

namespace App;

use App\Commentable;
use App\Dependant;
use App\Expandable;
use App\Nameable;
use App\Scopeable;
use App\Typeable;
use App\Exception\AbstractMethodDefinitionException;
use App\Exception\AnonymousArgumentException;
use App\Exception\AnonymousMethodException;
use App\Exception\DuplicateArgumentException;
use App\Exception\FinalMethodDeclarationException;
use App\Exception\InvalidArgumentNameException;
use App\Exception\InvalidMethodNameDeclarationException;
use App\Exception\InvalidMethodNameDefinitionException;

final class Method implements MethodInterface
{
	use Commentable;
	use Dependant;
	use Expandable;
	use Nameable;
	use Scopeable;
	use Typeable;

	public const FLUENT = 'self';

	/**
	 * @var bool - is the method static ?
	 */
	private bool $isStatic = false;

	/**
	 * @var ArgumentInterface[] - the list of arguments of the method
	 */
	private array $arguments = [];

	/**
	 * @var string[] - the list of statements of the method
	 */
	private array $statements = [];

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
		
		$this->arguments[] = $argument;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	public function addStatement(string $statement): self
	{
		$this->statements[] = $statement;

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

		$buffer = '';
		if ($this->hasComment()) {
			$buffer .= $this->getDocString();
		}
		$buffer .= $this->getCanonicalDeclaration() . ';';

		echo $buffer;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	final public function getDefinition(): self
	{
		if (! $this->isNamed()) {
			throw new AnonymousMethodException('definition');
		} else if (! $this->hasValidName()) {
			throw new InvalidMethodNameDefinitionException($this->name);
		} else if ($this->isAbstract()) {
			throw new AbstractMethodDefinitionException($this->name);
		}

		$buffer = '';
		if ($this->hasComment()) {
			$buffer .= $this->getDocString();
		}
		$buffer .= $this->getCanonicalDeclaration() . PHP_EOL;
		
		$buffer .= '{' . PHP_EOL;
		foreach ($this->statements as $statement) {
			$buffer .= "\t$statement" . PHP_EOL;
		}
		if ($this->canonicalType === self::FLUENT) {
			if (count($this->statements)) { // blank line after statements
				$buffer .= PHP_EOL;
			}
			$buffer .= "\treturn \$this;" . PHP_EOL;
		}
		$buffer .= '}';

		echo $buffer;

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
	 * @return string - the doc string of the method
	 */
	final private function getDocString(): string
	{
		$docString = '/**' . PHP_EOL . ' * ' . $this->comment . PHP_EOL;

		if (count($this->arguments)) {
			$docString .= ' *' . PHP_EOL;
			foreach ($this->arguments as $argument) {
				$docString .= ' * @param ' . $argument->getCanonicalType() . ' - ';
				$docString .= $argument->hasComment() ? $argument->getComment() : 'COMMENT ME';
				$docString .= PHP_EOL;
			}
		}

		if ($this->isTyped()) {
			$docString .= ' *' . PHP_EOL . ' * @return ' . $this->getCanonicalType() . PHP_EOL;
		}

		$docString .= ' */' . PHP_EOL;

		return $docString;
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
			// if ($this->canonicalType === self::FLUENT) {
				
			// }
			$buffer .= ': ' . $this->getCanonicalType();
		}

		return $buffer;
	}
}