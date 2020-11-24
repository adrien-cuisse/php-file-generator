<?php

namespace App\Exception;

final class AbstractMethodDefinitionException extends \LogicException
{
	public function __construct(string $className)
	{
		parent::__construct(
			"Tried to get get definition of method [$className] which is abstract"
		);
	}
}