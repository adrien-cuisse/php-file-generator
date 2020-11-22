<?php

namespace App;

/**
 * Provides the ability to be abstract or final
 */
interface ExpandableInterface
{
	/**
	 * @return string|null - the abstract/final modifier, if any
	 */
	public function getExpandability(): ?string;

	/**
	 * Makes it abstract
	 * 
	 * @return self
	 */
	public function makeAbstract(): self;

	/**
	 * @return bool - true if the method is abstract, false otherwise
	 */
	public function isAbstract(): bool;

	/**
	 * Makes it final
	 * 
	 * @return self
	 */
	public function makeFinal(): self;

	/**
	 * @return bool - true if the method is final, false otherwise
	 */
	public function isFinal(): bool;

	/**
	 * @return bool - true if it has abstract or final modifier, false otherwise
	 */
	public function hasExpandability(): bool;
}