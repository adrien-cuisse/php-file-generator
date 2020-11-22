<?php

namespace App;

/**
 * Provides an identifier
 */
interface NameableInterface
{	
	/**
	 * @return string - the name, if any
	 */
	public function getName(): ?string;

	/**
	 * @param string - the name to set
	 * 
	 * @return self;
	 */
	public function setName(string $name): self;

	/**
	 * @return bool - true if a name was provided, false otherwise
	 */
	public function isNamed(): bool;

	/**
	 * @return bool - true is the name is a valid identifier, false otherwise
	 */
	public function hasValidName(): bool;
}