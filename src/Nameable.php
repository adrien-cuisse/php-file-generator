<?php

namespace App;

trait Nameable
{
	/**
	 * @var string - the identifier, should be unique
	 */
	private ?string $name = null;

	/**
	 * @see NameableInterface
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @see NameableInterface
	 */
	public function setName(string $name): self
	{
		$this->name = trim($name);
	
		return $this;
	}

	/**
	 * @see NameableInterface
	 */
	final public function isNamed(): bool
	{
		if (null === $this->name) {
			return false;
		}

		return '' !== $this->name;
	}

	/**
	 * @see NameableInterface
	 */
	public function hasValidName(): bool
	{
		return $this->isNamed() && $this->isValidName($this->name);
	}

	/**
	 * @param string|null - the name to check
	 * 
	 * @return bool - true is the identifier is valid, false otherwise
	 */
	private function isValidName(?string $name): bool
	{
		if (null === $name) {
			return false;
		}

		return 0 !== preg_match(
			'/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', 
			$name
		);
	}
}