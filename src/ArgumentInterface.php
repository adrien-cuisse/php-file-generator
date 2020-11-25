<?php

namespace App;

use App\CommentableInterface;
use App\NameableInterface;
use App\TypeableInterface;

/**
 * The argument of a method
 */
interface ArgumentInterface extends CommentableInterface, NameableInterface, TypeableInterface
{
	/**
	 * @param string - the name of the argument
	 * 
	 * @throws InvalidNameException - if the name is not a valid identifier
	 */
	public function __construct(string $name);
}