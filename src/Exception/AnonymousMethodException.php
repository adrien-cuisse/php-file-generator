<?php

namespace App\Exception;

final class AnonymousMethodException extends \LogicException
{
	/**
	 * @param string - either 'declaration' or 'definition'
	 */
	public function __construct(string $codeType)
	{
		parent::__construct("Tried to get the {$codeType} of an anonymous method");
	}
}