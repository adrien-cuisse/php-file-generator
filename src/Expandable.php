<?php

namespace App;

trait Expandable
{
	/**
	 * @var string|null - the abstract/final modifier, if any
	 */
	private ?string $expandability = null;
	
	/**
	 * @see ExpandableInterface
	 */
	final public function makeAbstract(): self
	{
		$this->expandability = 'abstract';

		return $this;
	}

	/**
	 * @see ExpandableInterface
	 */
	final public function isAbstract(): bool
	{
		return 'abstract' === $this->expandability;
	}

	/**
	 * @see ExpandableInterface
	 */
	final public function makeFinal(): self
	{
		$this->expandability = 'final';

		return $this;
	}

	/**
	 * @see ExpandableInterface
	 */
	final public function isFinal(): bool
	{
		return 'final' === $this->expandability;
	}

	/**
	 * @see ExpandableInterface
	 */
	final public function getExpandability(): ?string
	{
		return $this->expandability;
	}

	/**
	 * @see ExpandableInterface
	 */
	final public function hasExpandability(): bool
	{
		return null !== $this->expandability;
	}
}