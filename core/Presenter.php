<?php


namespace Core;


use ReflectionClass;
use RuntimeException;
use stdClass;

abstract class Presenter
{
    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * @var array Data
     */
    protected stdClass $data;

    /**
     * @var array Request args
     */
    protected array $requestArgs = [];

    /**
     * Presenter constructor.
     */
    public function __construct()
    {
        $this->reflection = new ReflectionClass($this);
        $this->data = new stdClass();
    }

    /**
     *
     */
    public function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Run presenter
     *
     * @param mixed ...$args
     */
    public function run(... $args): void
    {
        $this->requestArgs = $args;

        if ($this->reflection->hasMethod('setup')) {
            $this->setup();
        }

        $this->process(... $args);
    }

    /**
     * @param string $templateName
     */
    public function render($templateName = 'default'): void
    {
        $escapedName = preg_replace('/[^a-z0-9]/', '', $templateName);
        $presenterName = ucfirst($this->reflection->getShortName());

        $path = __DIR__ . "/../app/views/{$presenterName}.{$escapedName}.phtml";

        if (file_exists($path)) {
            extract(get_object_vars($this->data), EXTR_OVERWRITE);

            require $path;
        } else {
            throw new RuntimeException("View {$templateName} not found");
        }
    }
}