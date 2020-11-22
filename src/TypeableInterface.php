<?php

namespace App;

/**
 * Provides a type
 */
interface TypeableInterface
{	
	/**
	 * @param string - the name of the type
	 * 
	 * @return self
	 */
	public function setType(string $type): self;

	/**
	 * @return bool - true if a type has been provided, false otherwise
	 */
	public function isTyped(): bool;

	/**
	 * @return bool - true is no qualified name exists, false otherwise
	 */
	public function isCanonical(): bool;

	/**
	 * @return bool - true is a qualified name exists, false otherwise
	 */
	public function isNamespaced(): bool;	

	/**
	 * @return string - the name of the type (without namespace, if any 
	 */
	public function getCanonicalType(): ?string;

	/**
	 * @return string|null - the fully qualified name of type (including namespace), if any
	 */
	public function getQualifiedType(): ?string;
}