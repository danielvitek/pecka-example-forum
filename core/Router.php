<?php

use Core\Presenter;

class Router
{

	/**
	 * @var string Request string
	 */
	private string $request;

	/**
	 * @var NULL|array Request string array
	 */
	private ?array $requestParsed;


	/**
	 * Router constructor.
	 *
	 * @param string $request Requested URL string
	 */
	public function __construct(string $request)
	{
		$this->request = ltrim($request, '/');
		$this->requestParsed = $this->request ? explode('/', $this->request) : [];

		spl_autoload_register([$this, 'autoloader']);
	}


	/**
	 * Autoloader
	 *
	 * @param string $className
	 */
	public function autoloader(string $className) : void
	{
		$parts = explode('\\', $className);

		$className = array_pop($parts);
		$namespace = strtolower(implode('/', $parts));

		$path = __DIR__ . "/../{$namespace}/{$className}.php";

		if (file_exists($path)) {
			require $path;
		} else {
			throw new RuntimeException("{$className} not found");
		}
	}


	/**
	 * Process request
	 */
	public function process() : void
	{
		$presenterName = empty($this->requestParsed) ? 'index' : array_shift($this->requestParsed);
		$escapedName = ucfirst(preg_replace('/[^a-z0-9]/', '', $presenterName));

		try {
			$reflection = new ReflectionClass("App\\Controllers\\{$escapedName}");
		} catch (RuntimeException) {
			$reflection = new ReflectionClass("App\\Controllers\\Error");
		}

		/** @var Presenter $instance */
		$instance = $reflection->newInstance();
		$instance->run(... $this->requestParsed);
	}

}
