<?php

namespace App;

trait Scopeable
{
	/**
	 * @var string - the scope
	 */
	private string $scope = 'private';

	/**
	 * @see ScopeableInterface
	 */
	public function getScope(): string
	{
		return $this->scope;
	}

	/**
	 * @see ScopeableInterface
	 */
	public function makePublic(): self
	{
		$this->scope = 'public';

		return $this;
	}

	/**
	 * @see ScopeableInterface
	 */
	public function makeProtected(): self
	{
		$this->scope = 'protected';

		return $this;
	}

	/**
	 * @see ScopeableInterface
	 */
	public function makePrivate(): self
	{
		$this->scope = 'private';

		return $this;
	}
}