<?php

namespace App;

use App\Exception\InvalidNameException;

trait Nameable
{
	/**
	 * @var string|null - the mapped name, if any
	 */
	private ?string $name = null;

	/**
	 * @see NameableInterface
	 */
	final public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @see NameableInterface
	 */
	final public function setName(string $name): self
	{
		if (! $this->isValidName($name)) {
			throw new InvalidNameException($name);
		}

		$this->name = $name;

		return $this;
	}

	/**
	 * @see NameableInterface
	 */
	final public function isNamed(): bool
	{
		return null !== $this->name;
	}

	/**
	 * @return bool - true if the given name is a valid identifier, false otherwise
	 */
	final private function isValidName(string $name): bool
	{
		return 1 === preg_match(
			'/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/',
			$name
		);
	}
}