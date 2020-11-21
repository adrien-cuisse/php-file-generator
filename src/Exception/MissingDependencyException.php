<?php

namespace App\Exception;

final class MissingDependencyException extends \LogicException
{
	public function __construct(string $name)
	{
		parent::__construct("Tried to access dependency {$name} but it wasn't added in the container");
	}
}