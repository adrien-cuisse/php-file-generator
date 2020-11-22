<?php

namespace App\Exception;

final class AnonymousArgumentException extends \InvalidArgumentException
{
	public function __construct(?string $methodName)
	{
		parent::__construct(
			sprintf(
				"Tried to add anonymous argument to %s method%s",
				$methodName === null ? 'anonymous' : '',
				$methodName !== null ? ' "' . $methodName  . '"' : '' 
			)
		);
	}
}