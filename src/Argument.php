<?php

namespace App;

use App\ArgumentInterface;

/**
 * @see ArgumentInterface
 */
final class Argument implements ArgumentInterface
{
	/**
	 * @var string - the name of the argument
	 */
	private string $name = '';
	
	/** 
	 * @var string|null - the type of the argument, null for mixed (not to specify)
	*/
	private ?string $type = null;

	/**
	 * @var string - the description of the argument
	 */
	private string $description = 'COMMENT ME';

	/**
	 * @see ArgumentInterface
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @see @ArgumentInterface
	 */
	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @see ArgumentInterface
	 */
	public function getType(): ?string
	{
		return $this->type;
	}

	/**
	 * @see ArgumentInterface
	 */
	public function setType(string $type): self
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @see ArgumentInterface
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @see ArgumentInterface
	 */
	public function setDescription(string $description): self
	{
		$this->description = $description;
		
		return $this;
	}
}