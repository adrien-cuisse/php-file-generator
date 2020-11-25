<?php

namespace App\Exception;

/**
 * Tried to assign a type with invalid name
 */
final class DuplicateArgumentException extends \InvalidArgumentException
{
	final public function __construct(string $methodName, string $argumentName)
	{
		parent::__construct(sprintf(
			'The method %s already has an argument named %s',
			$methodName,
			$argumentName
		));
	}
}