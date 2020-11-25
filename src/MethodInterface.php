<?php

namespace App;

use App\ArgumentInterface;
use App\CommentableInterface;
use App\NameableInterface;
use App\ScopeableInterface;
use App\TypeableInterface;

interface MethodInterface extends CommentableInterface, NameableInterface, ScopeableInterface, TypeableInterface
{
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
	 * @return string - the declaration string of the method
	 */
	public function getDeclaration(): string;
}