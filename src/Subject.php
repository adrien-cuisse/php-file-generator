<?php

namespace App;

use App\Commentable;
use App\Dependant;
use App\MethodInterface;
use App\Nameable;

trait Subject
{
	use Commentable;
	use Dependant;
	use Nameable;

	/**
	 * @var MethodInterface[] - the list of stored methods
	 */
	private array $methods = [];

	/**
	 * @see SubjectInterface
	 */
	public function getMethods(): array
	{
		return $this->methods;
	}

	/**
	 * @see SubjectInterface
	 * Addable methods requirements depend of the subject
	 */
	public abstract function addMethod(MethodInterface $method): self;

	/**
	 * @see SubjectInterface
	 */
	public abstract function getDefinition(): string; 
}