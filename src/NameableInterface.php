<?php

namespace App;

/**
 * Provides a name
 */
interface NameableInterface
{
	/**
	 * @return string|null - the mapped name, if any
	 */
	public function getName(): ?string;

	/**
	 * @param string - the name to set
	 * 
	 * @throws InvalidNameException - if the provided name is an invalid identifier
	 */
	public function setName(string $name): self;

	/**
	 * @return bool - true if it was named, false otherwise
	 */
	public function isNamed(): bool;
}