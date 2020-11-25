<?php

namespace App;

/**
 * Provides comments
 */
interface CommentableInterface
{
	/**
	 * @var string - the mapped comment
	 */
	public function getComment(): ?string;

	/**
	 * @param string - the comment to set
	 */
	public function setComment(string $comment): self;

	/**
	 * @return bool - true if a comment was set, false otherwise
	 */
	public function hasComment(): bool;
}