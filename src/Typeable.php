<?php

namespace App;

use App\Dependant;
use App\Exception\InvalidTypeException;

trait Typeable
{
	use Dependant;

	/**
	 * @param string|null - the type without namespace, if any
	 */
	private ?string $canonicalType = null;

	/**
	 * @var string|null - the namespaced type, if any
	 */
	private ?string $qualifiedType = null;

	/**
	 * @see TypeableInterface
	 */
	final public function setType(string $type): self
	{
		if (! $this->isValidType($type)) {
			throw new InvalidTypeException($type);
		}

		$offset = strrpos($type, '\\');

		if (false !== $offset) {
			$this->qualifiedType = $type;
			$type = substr($type, $offset + 1);
			$this->addDependency($type);
		} else {
			$this->qualifiedType = null;
		}

		$this->canonicalType = $type;

		return $this;
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
	final public function getQualifiedType(): ? string
	{
		return $this->qualifiedType;
	}

	/**
	 * @see TypeableInterface
	 */
	public function isTyped(): bool
	{
		return null !== $this->canonicalType;
	}

	/**
	 * @see TypeableInterface
	 */
	public function isNamespaced(): bool
	{
		return $this->isTyped() && null !== $this->qualifiedType;
	}

	/**
	 * @return bool - true if the type is valid, false otherwise
	 */
	final private function isValidType(string $type): bool
	{
		$tokens = explode('\\', $type);
		
		if (empty($tokens)) {
			$tokens[] = $type;
		}

		foreach($tokens as $token) {
			if (0 === preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $token)) {
				return false;
			}
		}

		return true;
	}
}