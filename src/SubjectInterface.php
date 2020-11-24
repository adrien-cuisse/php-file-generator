<?php

namespace App;

use App\CommentableInterface;
use App\DependantInterface;
use App\MethodInterface;
use App\NameableInterface;

/**
 * The subject of a PHP file, being an interface, a class, or a trait
 */
interface SubjectInterface extends CommentableInterface, DependantInterface, NameableInterface
{
	/**
	 * @return MethodInterface - the list of stored interface
	 */
	public function getMethods(): array;

	/**
	 * @param MethodInterface - the method to add
	 * 
	 * @return self
	 */
	public function addMethod(MethodInterface $method): self;

	/**
	 * @return InterfaceInterface - the list of stored interfaces
	 */
	// public function getInterfaces(): array;
	
	/**
	 * @param InterfaceInterface - the interface to add to the suject
	 * 
	 * @return self
	 */
	// public function addInterface(InterfaceInterface $interface): self;

	/**
	 * @return string - the subject's PHP code
	 */
	public function getDefinition(): string;
}