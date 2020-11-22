<?php

namespace App\Exception;

final class InvalidMethodNameDeclarationException extends \LogicException
{
	public function __construct(string $methodName)
	{
		parent::__construct(sprintf(
			'Tried to get declaration of method [%s] which has invalid name',
			$methodName
		));
	}
}