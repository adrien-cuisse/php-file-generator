<?php

namespace App;

use App\ArgumentInterface;
use App\Exception\AnonymousArgumentException;
use App\Exception\MisnamedArgumentException;
use App\Exception\DuplicateArgumentException;

final class Method implements MethodInterface
{
	private const ABSTRACT_MODIFIER = 'abstract';

	private const FINAL_MODIFIER = 'final';

	private const PRIVATE_SCOPE = 'private';

	private const PROTECTED_SCOPE = 'protected';

	private const PUBLIC_SCOPE = 'public';
	
	/**
	 * @var string - the name of the method
	 */
	private string $name = '';

	/**
	 * @var string|null - the return type, null for mixed (not to specify)
	 */
	private ?string $returnType = null;

	/**
	 * @var ArgumentInterface[] - the list of arguments of the method
	 */
	private array $arguments = [];

	/**
	 * @var string - the modifier, abstract or final
	 */
	private ?string $modifier = null;

	/**
	 * @var string - the scope of the method
	 */
	private string $scope = self::PRIVATE_SCOPE;

	/**
	 * @see MethodInterface
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @see MethodInterface
	 */
	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	public function getReturnType(): ?string
	{
		return $this->returnType;
	}

	/**
	 * @see MethodInterface
	 */
	public function setReturnType(string $returnType): self
	{
		$this->returnType = $returnType;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	public function getArguments(): array
	{
		return $this->arguments;
	}

	/**
	 * @see MethodInterface
	 */
	public function addArgument(ArgumentInterface $argument): self
	{
		if ($argument->getName() === '') {
			throw new AnonymousArgumentException($this->getName());
		}

		if (0 === preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $argument->getName())) {
			throw new MisnamedArgumentException($this->getName(), $argument->getName());
		}

		foreach ($this->arguments as $storedArgument) {
			if ($storedArgument->getName() === $argument->getName()) {
				throw new DuplicateArgumentException($this->getName(), $argument->getName());
			}
		}

		// extracts namespace from type and put it has dependency
		$type = $argument->getType();
		if (false !== strpos($type, '\\')) {
			// $this->addDependency($type);
			$offset = strrpos($type, '\\');
			$argument->setType(substr($type, $offset + 1));
		}

		$this->arguments[] = $argument;

		return $this;
	}

	/**
	 * @see MethodInterface
	 */
	public function makeAbstract(): self
	{
		$this->modifier = self::ABSTRACT_MODIFIER;

		return $this;
	}

	/**
	 * @see @MethodInterface
	 */
	public function isAbstract(): bool
	{
		return self::ABSTRACT_MODIFIER === $this->modifier;
	}

	/**
	 * @see MethodInterface
	 */
	public function makeFinal(): self
	{
		$this->modifier = self::FINAL_MODIFIER;

		return $this;
	}

	/**
	 * @see @MethodInterface
	 */
	public function isFinal(): bool
	{
		return self::FINAL_MODIFIER === $this->modifier;
	}

	/**
	 * @see MethodInterface 
	 */
	public function getModifier(): ?string
	{
		return $this->modifier;
	}

	/**
	 * @see @MethodInterface
	 */
	public function makePublic(): self
	{
		$this->scope = self::PUBLIC_SCOPE;

		return $this;
	}
	
	/**
	 * @see @MethodInterface
	 */
	public function makeProtected(): self
	{
		$this->scope = self::PROTECTED_SCOPE;

		return $this;
	}
	
	/**
	 * @see @MethodInterface
	 */
	public function makePrivate(): self
	{
		$this->scope = self::PRIVATE_SCOPE;

		return $this;
	}

	/**
	 * @see @MethodInterface
	 */
	public function getScope(): string
	{
		return $this->scope;
	}

	/**
	 * @see @MethodInterface
	 */
	public function writeDeclaration(): self
	{
		$buffer = '';

		$buffer .= $this->modifier ? $this->modifier . ' ' : '';
		$buffer .= $this->scope . ' function ' . $this->name . '(' . PHP_EOL;

		foreach ($this->arguments as $argument) {
			$buffer .= $argument->getType() . '$' . $argument->getName();
		// 	if ($argument !== end($$this->arguments)) {
		// 		$buffer .= ',';
		// 	}
		// 	$buffer .= PHP_EOL;
		}
		$buffer .= ') {}';

		echo $buffer;

		return $this;
	}
}