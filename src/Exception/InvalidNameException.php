<?php

namespace App\Exception;

/**
 * Tried to assign an invalid name
 */
final class InvalidNameException extends \InvalidArgumentException
{
	final public function __construct(string $name)
	{
		parent::__construct(sprintf(
			'Tried to assign the name %s, which is invalid', $name
		));
	}
}