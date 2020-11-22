<?php

namespace App\Exception;

final class InvalidArgumentNameException extends \InvalidArgumentException
{
	public function __construct(?string $methodName, string $argumentName)
	{
		parent::__construct(
			sprintf(
				"Tried to add argument with invalid name [%s] to %s method%s",
				$argumentName,
				$methodName === null ? 'anonymous' : '',
				$methodName !== null ? ' [' . $methodName  . ']' : '' 
			)
		);
	}
}