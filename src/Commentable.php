<?php

namespace App;

trait Commentable
{
	/**
	 * @var string|null - the mapped comment
	 */
	private ?string $comment = null;

	/**
	 * @var string - the mapped comment
	 */
	final public function getComment(): ?string
	{
		return $this->comment;
	}

	/**
	 * @param string - the comment to set
	 */
	final public function setComment(string $comment): self
	{
		$this->comment = $comment;

		return $this;
	}

	/**
	 * @return bool - true if a comment was set, false otherwise
	 */
	final public function hasComment(): bool
	{
		return null !== $this->comment;
	}
}