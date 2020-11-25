<?php

namespace App\Exception;

/**
 * Tried to assign a type with invalid name
 */
final class InvalidTypeException extends \InvalidArgumentException
{
	final public function __construct(string $type)
	{
		parent::__construct(sprintf(
			'Tried to assign the type %s, which is invalid', $type
		));
	}
}