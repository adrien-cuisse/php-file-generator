<?php

namespace App;

/**
 * The argument of a method
 */
interface ArgumentInterface
{
	/**
	 * @return string - the name of the argument
	 */
	public function getName(): string;

	/**
	 * @param string - the name to set
	 * 
	 * @return self
	 */
	public function setName(string $name): self;

	/**
	 * @return string|null - the type of the argument, null for mixed (unknown type)
	 */
	public function getType(): ?string;

	/**
	 * @param string - the type to set
	 * 
	 * @return self
	 */
	public function setType(string $type): self;

	/**
	 * @return string - the description of the argument
	 */
	public function getDescription(): string;

	/**
	 * @param string - the description to set
	 * 
	 * @return self
	 */
	public function setDescription(string $description): self;
}