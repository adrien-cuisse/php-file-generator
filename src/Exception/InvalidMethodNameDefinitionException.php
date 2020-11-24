<?php

namespace App\Exception;

final class InvalidMethodNameDefinitionException extends \LogicException
{
	public function __construct(string $methodName)
	{
		parent::__construct(sprintf(
			'Tried to get definition of method [%s] which has invalid name',
			$methodName
		));
	}
}