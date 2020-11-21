<?php

namespace App;

interface DependencyInterface
{
	public function setName(string $name): self;

	public function getQualifiedName(): string;

	public function getCanonicalName(): string;

	public static function isQualified(): bool;

	public static function isCanonical(string $name): bool;
}