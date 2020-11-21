<?php

namespace App\Exception;

final class DuplicateArgumentException extends \InvalidArgumentException
{
	public function __construct(string $methodName, string $argumentName)
	{
		parent::__construct("The method [{$methodName}] already has an argument named [{$argumentName}]");
	}
}