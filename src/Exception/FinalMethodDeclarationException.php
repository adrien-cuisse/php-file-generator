<?php

namespace App\Exception;

final class FinalMethodDeclarationException extends \LogicException
{
	/**
	 * @param string - either 'declaration' or 'definition'
	 */
	public function __construct(string $methodName)
	{
		parent::__construct("Tried to get the declaration of the method [{$methodName}], which is final");
	}
}