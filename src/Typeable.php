<?php

namespace App;

trait Typeable
{
	/**
	 * @see TypeableInterface
	 */
	private ?string $qualifiedType = null;

	/**
	 * @see TypeableInterface 
	 */
	private ?string $canonicalType = null;
	
	/**
	 * @see TypeableInterface
	 */
	final public function setType(string $type): self
	{
		$type = trim($type);

		$offset = strrpos($type, '\\');
		
		if (false !== $offset) {
			$this->qualifiedType = $type;
			$type = substr($type, $offset + 1);
		} else {
			$this->qualifiedType = null;
		}
		
		$this->canonicalType = $type;

		return $this;
	}

	/**
	 * @see TypeableInterface
	 */
	final public function isTyped(): bool
	{
		return null !== $this->canonicalType;
	}

	/**
	 * @return bool - true is no qualified name exists, false otherwise
	 */
	public function isCanonical(): bool
	{
		return $this->isTyped() && null === $this->qualifiedType;
	}
	
	/**
	 * @see TypeableInterface
	 */
	public function isNamespaced(): bool
	{
		return null !== $this->qualifiedType;
	}

	/**
	 * @see TypeableInterface
	 */
	final public function getCanonicalType(): ?string
	{
		return $this->canonicalType;
	}

	/**
	 * @see TypeableInterface
	 */
	final public function getQualifiedType(): ?string
	{
		return $this->qualifiedType;
	}

	// /**
	//  * @see TypeableInterface
	//  */
	// final public function hasNamespacedType(): bool
	// {
	// 	return null !== $this->qualifiedType;
	// }

	// /**
	//  * @see TypeableInterface
	//  */
	// final public function hasCanonicalType(): bool
	// {
	// 	return null === $this->qualifiedType;
	// }
}