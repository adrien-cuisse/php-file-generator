<?php

namespace App;

use App\ArgumentInterface;
use App\Commentable;
use App\Nameable;
use App\Typeable;

final class Argument implements ArgumentInterface
{
	use Commentable;
	use Nameable;
	use Typeable;

	/**
	 * @param string - the name of the argument
	 */
	final public function __construct(string $name)
	{
		$this->setName($name);
	}
}