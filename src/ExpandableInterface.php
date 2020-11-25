<?php

namespace App;

/**
 * Provides the ability to be abstract or final
 */
interface ExpandableInterface
{
	/**
	 * Makes it abstract
	 * 
	 * @return self
	 */
	public function makeAbstract(): self;

	/**
	 * @return bool - true if it is final, false otherwise
	 */
	public function isAbstract(): bool;

	/**
	 * Makes it final
	 * 
	 * @return self
	 */
	public function makeFinal(): self;

	/**
	 * @return bool - true if it is final, false otherwise
	 */
	public function isFinal(): bool;

	/**
	 * @return string - the abstract/final keyword, if any
	 */
	public function getExpandability(): ?string;

	/**
	 * @return bool - true if it has an abstract/final modifier
	 */
	public function hasExpandability(): bool;
}