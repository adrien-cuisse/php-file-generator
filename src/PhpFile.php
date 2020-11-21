<?php

namespace App;

use App\PhpFileInterface;

/**
 * @see @PhpFileInterface
 */
abstract class PhpFile implements PhpFileInterface
{
	/**
	 * @var string|null - the fully qualified class/interface/trait name (including namespace)
	 * eg: Symfony\Bundle\FrameworkBundle\Controller\AbstractController
	 * eg: App\SomeInterface
	 */
	private ?string $fullyQualifiedSubject = null;

	/**
	 * @var string|null - class/interface name without namespace
	 * eg: ServerRequestInterface
	 * eg: AbstractController
	 */
	private ?string $subject = null;

	/**
	 * @var bool - is it a source of the current project or is it in vendor ?
	 */
	private ?bool $isInternal = null;

	/**
	 * @var string|null - the root directory of the project, from the filesystem root
	 * eg: /some/directory
	 */
	private ?string $rootDirectoryPath = null;

	/**
	 * @var string|null - the path to the file, from the filesystem root
	 * eg: /some/directory/src/Controller/FooController.php
	 */
	private ?string $absolutePath = null;

	/**
	 * @var string|null - the path to the file, from the root directory
	 * eg: src/Controller/FooController.php
	 */
	private ?string $relativePath = null;

	/**
	 * @var string|null - the namespace of the file
	 * eg: App\Controller
	 */
	private ?string $namespace = null;

	/**
	 * @var string|null - the base namespace, usually 'App'
	 */
	private ?string $rootNamespace = null;

	/**
	 * @var string|null - the name of the file, without path
	 * eg: FooController.php
	 */
	private ?string $name = null;

	/**
	 * @var PhpFile[] - list of files required for this one
	 */
	private array $dependencies = [];

	/**
	 * @param string - the fully qualified name of the subject defined in the file
	 * eg: Symfony\Bundle\FrameworkBundle\Controller\AbstractController
	 * eg: Psr\Http\Message\ServerRequestInterface
	 * eg: App\Kernel\KernelTrait
	 */
	public function __construct(string $fullyQualifiedSubject)
	{
		$this->fullyQualifiedSubject = $fullyQualifiedSubject;
		$this->isInternal = (0 === strpos($fullyQualifiedSubject, 'App\\'));
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getQualifiedSubject(): string
	{
		return $this->fullyQualifiedSubject;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getSubject(): string
	{
		if (null === $this->subject) {
			$offset = strrpos($this->fullyQualifiedSubject, '\\');
			$this->subject = substr($this->fullyQualifiedSubject, $offset + 1);
		}

		return $this->subject;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function isInternal(): bool
	{
		return $this->isInternal;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getRootDirectoryPath(): string
	{
		if (null === $this->rootDirectoryPath) {
			$this->rootDirectoryPath = dirname(__DIR__);
		}

		return $this->rootDirectoryPath;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getRelativePath(): string
	{
		if (null === $this->relativePath) {
			$tokens = explode('\\', $this->fullyQualifiedSubject);
			array_shift($tokens);
			array_unshift($tokens, 'src');
			$this->relativePath = implode(DIRECTORY_SEPARATOR, $tokens) . '.php';
		}

		return $this->relativePath;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getAbsolutePath(): string
	{
		if (null === $this->absolutePath) {	
			$this->absolutePath = $this->getRootDirectoryPath() 
				. DIRECTORY_SEPARATOR 
				. $this->getRelativePath()
			;
		}

		return $this->absolutePath;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getNamespace(): string
	{
		if (null === $this->namespace) {
			$length = strrpos($this->fullyQualifiedSubject, '\\');
			$this->namespace = substr($this->fullyQualifiedSubject, 0, $length);
		}

		return $this->namespace;
	}

	final public function getRootNamespace(): string
	{
		if (null === $this->rootNamespace) {
			$length = strpos($this->fullyQualifiedSubject, '\\');
			$this->rootNamespace = substr($this->fullyQualifiedSubject, 0, $length);
		}

		return $this->rootNamespace;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getName(): string
	{
		if (null === $this->name) {
			$offset = strrpos($this->fullyQualifiedSubject, '\\');
			$this->name = substr($this->fullyQualifiedSubject, $offset + 1) . '.php';
		}

		return $this->name;
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function getDependencies(): array
	{
		return $this->dependencies;
	}

	final public function getDependency(string $fullyQualifiedSubject): PhpFileInterface
	{
		if (! $this->hasDependency($dependency)) {
			throw new MissingDependencyException($fullyQualifiedSubject);
		}

		return $this->dependencies[$fullyQualifiedSubject];
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function hasDependency(string $fullyQualifiedSubject): bool
	{
		return array_key_exists($fullyQualifiedSubject, $this->dependencies);
	}

	/**
	 * @see PhpFileInterface
	 */
	final public function addDependency(PhpFileInterface $dependency): self
	{
		$fullyQualifiedSubject = $dependency->getQualifiedSubject();

		if (! $this->hasDependency($fullyQualifiedSubject)) {
			$isInternal = (0 === strpos($fullyQualifiedSubject, $this->getRootNamespace()));
			$this->dependencies[$fullyQualifiedSubject] = $dependency;
		}

		return $this;
	}

	final protected function createDirectories(): self
	{
		if ($this->isInternal()) {
			$directories = explode(DIRECTORY_SEPARATOR, $this->getRelativePath());
			$directories = array_slice($directories, 1, count($directories) - 2);
	
			$currentPath = $this->getRootDirectoryPath() . DIRECTORY_SEPARATOR . 'src';

			foreach ($directories as $directory) {
				$currentPath .= DIRECTORY_SEPARATOR . $directory;
				if (! file_exists($currentPath)) {
					mkdir($currentPath);
				}
			}
		}

		return $this;
	}
}