<?php

namespace App;

use App\CommentableInterface;
use App\DependantInterface;
use App\ExpandableInterface;
use App\MethodInterface;
use App\NameableInterface;

/**
 * A PHP class
 */
interface ClassInterface extends CommentableInterface, DependantInterface, ExpandableInterface, NameableInterface
{
	/**
	 * @return MethodInterface[] - the list of methods of the class
	 */
	public function getMethods(): array;

	/**
	 * @param MethodInterface - adds a method to the class
	 * 
	 * @return self
	 */
	public function addMethod(MethodInterface $method): self;

	/**
	 * @return string - the PHP code of the class
	 */
	public function getDefinition(): string;
}