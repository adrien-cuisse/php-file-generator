<?php

namespace App;

use App\ArgumentInterface;
use App\CommentableInterface;
use App\NameableInterface;
use App\ScopeableInterface;
use App\TypeableInterface;

interface MethodInterface extends CommentableInterface, ExpandableInterface, NameableInterface, ScopeableInterface, TypeableInterface
{
	/**
	 * @param string - the name of the method
	 * 
	 * @throws InvalidNameException - if the name is not a valid identifier
	 */
	public function __construct(string $name);

	/**
	 * @return ArgumentInterface - the list of arguments
	 */
	public function getArguments(): array;

	/**
	 * @param ArgumentInterface - the argument to add
	 * 
	 * @throws DuplicateArgumentException - if the method already has an argument named like the given one
	 */
	public function addArgument(ArgumentInterface $argument): self;

	/**
	 * @return bool - true if the method has arguments, false otherwise
	 */
	public function hasArguments(): bool;

	/**
	 * Makes the method static
	 * 
	 * @return self
	 */
	public function makeStatic(): self;

	/**
	 * @return bool - true if the method is static, false otherwise
	 */
	public function isStatic(): bool;

	/**
	 * @return string - the doc block of the method
	 */
	public function getDocBlock(): string;

	/**
	 * @return string - the declaration string of the method
	 */
	public function getDeclaration(): string;

	/**
	 * @return string - the declaration string of the method
	 * 
	 * @throws AbstractMethodDefinitionException - if the method is abstract
	 */
	public function getDefinition(): string;
}