<?php

namespace App;

use App\ClassInterface;
use App\MethodInterface;
use App\Expandable;

final class _Class implements ClassInterface
{
	use Expandable;
	use Subject;

	/**
	 * @see SubjectInterface
	 */
	final public function addMethod(MethodInterface $method): self
	{
		// checkpoint

		return $this;
	}


	/**
	 * @see SubjectInterface
	 */
	final public function getDefinition(): string
	{

		return '';
	}
}