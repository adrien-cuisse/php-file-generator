<?php

namespace App\Exception;

final class DuplicateArgumentException extends \InvalidArgumentException
{
	public function __construct(?string $methodName, string $argumentName)
	{
		parent::__construct(
			sprintf(
				"Tried to add duplicate argument [%s] to %s method%s",
				$argumentName,
				$methodName === null ? 'anonymous' : '',
				$methodName !== null ? ' [' . $methodName  . ']' : '' 
			)
		);
	}}