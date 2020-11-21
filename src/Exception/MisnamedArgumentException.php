<?php

namespace App\Exception;

final class MisnamedArgumentException extends \InvalidArgumentException
{
	public function __construct(string $method, string $name)
	{
		parent::__construct("Tried to add argument named [{$name}] to method [{$method}]");
	}
}