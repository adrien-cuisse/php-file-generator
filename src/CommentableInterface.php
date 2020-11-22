<?php

namespace App;

/**
 * A comment on an argument, a method, class, etc
 */
interface CommentableInterface
{
	/**
	 * @return string - the comment
	 */
	public function getComment(): string;

	/**
	 * @param string - the comment to set
	 * 
	 * @return self
	 */
	public function setComment(string $comment): self;

	/**
	 * @return bool - true if it has a comment, false otherwise
	 */
	public function hasComment(): bool;
}