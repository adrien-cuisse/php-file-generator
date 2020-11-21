<?php

namespace App;

use App\DependencyInterface;

final class Dependency implements DependencyInterface
{
	private ?string $qualifiedName = null;

	private ?string $canonicalName = null;

	public function setName(string $name): self
	{
		$this->qualifiedName = $name;
		
		if (static::isQualified($name)) {
			$offset = strpos($name, '\\');
			$name = substr($name, $offset + 1);
		}

		$this->canonicalName = $name;
	}

	public function getQualifiedName(): ?string
	{
		return $this->qualifiedName;
	}

	public function getCanonicalName(): ?string
	{
		return $this->canonicalName;
	}

	public static function isQualified(string $name): bool
	{
		return ! static::isCanonical($name);
	}
	
	public static function isCanonical(string $name): bool
	{
		return false !== strpos($name, '\\');
	}
}