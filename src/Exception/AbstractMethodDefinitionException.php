<?php

namespace App\Exception;

final class AbstractMethodDefinitionException extends \LogicException
{
	final public function __construct(string $methodName)
	{
		parent::__construct(sprintf(
			'Can\'t define abstract method %s',
			$methodName
		));
	}
}