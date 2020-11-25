<?php

namespace App;

trait Scopeable
{
	/**
	 * @var string - the mapped scope
	 */
	private string $scope = 'private';

	/**
	 * @see ScopeableInterface
	 */
	final public function getScope(): string
	{
		return $this->scope;
	}

	/**
	 * @see ScopeableInterface
	 */
	final public function makePublic(): self
	{
		$this->scope = 'public';

		return $this;
	}

	/**
	 * @see ScopeableInterface
	 */
	final public function makeProtected(): self
	{
		$this->scope = 'protected';

		return $this;
	}

	/**
	 * @see ScopeableInterface
	 */
	final public function makePrivate(): self
	{
		$this->scope = 'private';

		return $this;
	}
}