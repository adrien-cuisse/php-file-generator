<?php

namespace App;

use App\CommentableInterface;
use App\DependantInterface;
use App\ExpandableInterface;
use App\NameableInterface;
use App\ScopeableInterface;
use App\TypeableInterface;

/**
 * A method inside a subject (interface, class or trait)
 */
interface MethodInterface extends CommentableInterface, DependantInterface, ExpandableInterface, NameableInterface, ScopeableInterface, TypeableInterface
{
	/**
	 * Makes the method static
	 * 
	 * @return self
	 */
	public function makeStatic(): self;

	/**
	 * @return bool - is the method static ? false if not configured
	 */
	public function isStatic(): bool;

	/**
	 * @return TypeableInterface[] - the list of arguments of the method
	 */
	public function getArguments(): array;

	/**
	 * @param ArgumentInterface - the argument to add
	 * 
	 * @throws AnonymousArgumentException - if no name was provided for the argument
	 * @throws InvalidArgumentNameException - if the name of the argument is invalid
	 * @throws DuplicateAgumentException - if an argument with the same name has already been added
	 * 
	 * @return self
	 */
	public function addArgument(ArgumentInterface $argument): self;

	/**
	 * @throws AnonymousMethodException - if method has not been named
	 * @throws InvalidMethodNameDeclarationException - if invalid name has been provided
	 * @throws FinalMethodDeclarationException - if the method is final
	 * 
	 * @return string - the PHP code to declare the method
	 */
	public function getDeclaration(): self;

	/**
	 * @return string - the PHP code to declare the method
	 */
	public function getDefinition(): self;
}