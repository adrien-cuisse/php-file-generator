<?php

namespace App;

/**
 * Provides a scope
 */
interface ScopeableInterface
{
	/**
	 * @return string - the mapped scope, 'private by default'
	 */
	public function getScope(): string;

	/**
	 * Sets the scope as 'public'
	 * 
	 * @return self
	 */
	public function makePublic(): self;

	/**
	 * Sets the scope as 'protected'
	 * 
	 * @return self
	 */
	public function makeProtected(): self;

	/**
	 * Sets the scope as 'private'
	 * 
	 * @return self
	 */
	public function makePrivate(): self;
}