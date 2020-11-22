<?php

namespace App;

/**
 * Provides a scope
 */
interface ScopeableInterface
{
	/**
	 * @return string - the scope, 'private' by default
	 */
	public function getScope(): string;

	/**
	 * Sets the scope to 'public'
	 * 
	 * @return self
	 */
	public function makePublic(): self;

	/**
	 * Sets the scope to 'protected'
	 * 
	 * @return self
	 */
	public function makeProtected(): self;

	/**
	 * Sets the scope to 'private'
	 * 
	 * @return self
	 */
	public function makePrivate(): self;
}