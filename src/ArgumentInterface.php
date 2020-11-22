<?php

namespace App;

use App\CommentableInterface;
use App\NameableInterface;
use App\TypeableInterface;

/**
 * The argument of a method
 */
interface ArgumentInterface extends CommentableInterface, NameableInterface, TypeableInterface
{

}