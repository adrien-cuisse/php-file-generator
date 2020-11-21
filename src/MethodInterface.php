<?php

namespace App;

use App\ArgumentInterface;

interface MethodInterface
{
	/**
	 * @return string - the name of the method
	 */
	public function getName(): string;

	/**
	 * @param string - the name to set
	 */
	public function setName(string $name): self;

	/**
	 * @return string|null - the return type, null for mixed (not to specify)
	 */
	public function getReturnType(): ?string;

	/**
	 * @param string - the return type of the method
	 * 
	 * @return self
	 */
	public function setReturnType(string $type): self;
	
	/**
	 * @return ArgumentInterface[] - the list of arguments of the method
	 */
	public function getArguments(): array;

	/**
	 * Adds an argument to the method, the type is modified to extract namespace
	 * 
	 * @throws AnonymousArgumentException - if no name was provided for the argument
	 * @throws DuplicateArgumentException - if an argument with the same name has already been added
	 * @throws MisnamedArgumentException - if argument name if invalid
	 * 
	 * @param ArgumentInterface - the argument to add
	 * 
	 * @return self
	 */
	public function addArgument(ArgumentInterface $argument): self;

	/**
	 * Makes the method abstract, overrides any makeFinal() call
	 * 
	 * @return self
	 */
	public function makeAbstract(): self;

	/**
	 * @return bool - true is the method is abstract, false otherwise
	 */
	public function isAbstract(): bool;

	/**
	 * Makes the method final, overrides any makeAbstract() call
	 * 
	 * @return self
	 */
	public function makeFinal(): self;

	/**
	 * @return bool - true is the method is final, false otherwise
	 */
	public function isFinal(): bool;

	/**
	 * @return string|null - the modifier (abstract/final) of the method, if any
	 */
	public function getModifier(): ?string;

	/**
	 * Sets the scope to public
	 * 
	 * @return self
	 */
	public function makePublic(): self;
	
	/**
	 * Sets the scope to protected
	 * 
	 * @return self
	 */
	public function makeProtected(): self;
	
	/**
	 * Sets the scope to private
	 * 
	 * @return self
	 */
	public function makePrivate(): self;

	/**
	 * @return string - the scope of the method (private by default)
	 */
	public function getScope(): string;

	/**
	 * Write the method declaration to STDOUT
	 * 
	 * @return self
	 */
	public function writeDeclaration(): self;
}