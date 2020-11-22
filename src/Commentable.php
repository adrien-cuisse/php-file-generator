<?php

namespace App;

trait Commentable
{
	/**
	 * @var string - the comment
	 */
	private string $comment = '';

	/**
	 * @see CommentableInterface
	 */
	final public function getComment(): string
	{
		return $this->comment;
	}

	/**
	 * @see CommentableInterface
	 */
	final public function setComment(string $comment): self
	{
		$this->comment = trim($comment);

		return $this;
	}

	/**
	 * @see CommentableInterface
	 */
	final public function hasComment(): bool
	{
		return '' !== $this->comment;
	}
}