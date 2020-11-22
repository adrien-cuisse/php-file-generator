<?php

namespace App;

use App\Commentable;
use App\Nameable;
use App\Typeable;

final class Argument implements ArgumentInterface
{
	use Commentable;
	use Nameable;
	use Typeable;
}