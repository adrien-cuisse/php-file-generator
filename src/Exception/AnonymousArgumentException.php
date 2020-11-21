<?php

namespace App\Exception;

final class AnonymousArgumentException extends \InvalidArgumentException
{
	public function __construct(string $methodName)
	{
		parent::__construct("Tried to add anonymous argument to method [{$methodName}]");
	}
}