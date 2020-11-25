<?php

namespace App;

use App\TypeableInterface;

/**
 * Provides a typing
 */
interface TypeableInterface extends DependantInterface
{
	/**
	 * @param string - the (potentially namespaced) type to set
	 * 
	 * @throws InvalidTypeException - if the given type is not a valid name
	 */
	public function setType(string $type): self;

	/**
	 * @return string|null - the namespaced type, if any
	 */
	public function getCanonicalType(): ?string;
	
	/**
	 * @return string|null - the canonical type, if any
	 */
	public function getQualifiedType(): ? string;

	/**
	 * @return bool - true if it's typed, false otherwise
	 */
	public function isTyped(): bool;

	/**
	 * @return bool - true if it's namespaced, false otherwise
	 */
	public function isNamespaced(): bool;
}