<?php

namespace App;

use App\ClassInterface;
use App\MethodInterface;
use App\Commentable;
use App\Dependant;
use App\Expandable;
use App\Nameable;

final class _Class implements ClassInterface
{
	use Commentable;
	use Dependant;
	use Expandable;
	use Nameable;
	use Scopeable;
	use Typeable;

	/**
	 * @var MethodInterface[] - the list of methods of the class
	 */
	private array $methods = [];

	/**
	 * @see ClassInterface
	 */
	public function getMethods(): array
	{
		return $this->methods;
	}

	/**
	 * @see ClassInterface
	 */
	public function addMethod(MethodInterface $method): self
	{
		// checkpoint

		return $this;
	}

	/**
	 * @see ClassInterface
	 */
	public function getDefinition(): string
	{

		return $this;
	}
}