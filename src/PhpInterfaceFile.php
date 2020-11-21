<?php

namespace App;

/**
 * @see PhpInterfaceFileInterface
 */
final class PhpInterfaceFile extends PhpFile implements PhpInterfaceFileInterface
{
	/**
	 * @return PhpFileInterface[] - the list of interfaces this one extends
	 */
	private array $parents = [];

	/**
	 * @param string - the fully qualified name of the interface defined in the file
	 * eg: Psr\Http\Message\ServerRequestInterface
	 */
	final public function __construct(string $fullyQualifiedName)
	{
		parent::__construct($fullyQualifiedName);
	}

	/**
	 * @see PhpInterfaceFileInterface
	 */
	final public function getParents(): array
	{
		return $this->parents;
	}

	/**
	 * @see PhpInterfaceFileInterface
	 */
	final public function addParent(PhpFileInterface $interface): self
	{
		$qualifiedName = $interface->getQualifiedSubject();
		
		if (! $this->hasParent($qualifiedName)) {
			$this->parents[$qualifiedName] = $interface;
			if (! $this->hasDependency($qualifiedName)) {
				$this->addDependency($interface);
			}
		}

		return $this;
	}

	/**
	 * @see PhpInterfaceFileInterface
	 */
	final public function hasParent(string $qualifiedInterfaceName): bool
	{
		return array_key_exists($qualifiedInterfaceName, $this->parents);
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function write(): self
	{
		throw new \Exception('method "write" is not implemented');

		if ($this->isInternal()) {
			$fileContent = [];

			$fileContent[] = '<?php';
			$fileContent[] = null;

			foreach ($this->getDependencies() as $depency) {
				$fileContent[] = 'use ' . $depency->getQualifiedSubject() . ';';
			}
			
		}

		var_dump($fileContent);

		return $this;
	}
}