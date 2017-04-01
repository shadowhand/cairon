<?php

namespace Cairon;

use Auryn\Injector;

class InjectorConfig
{
    /**
     * Create a new config instance
     *
     * @return static
     */
    public static function make(Injector $injector = null)
    {
        return new static($injector);
    }

    /**
     * @var Injector
     */
    private $injector;

    public function __construct(Injector $injector = null)
    {
        if (null === $injector) {
            $injector = new Injector();
        }

        $this->injector = $injector;
    }

    /**
     * Apply a configuration to the injector
     *
     * The configuration must either be callable, or be a class name that refers
     * to a callable class.
     *
     * @param callable|string $config
     *
     * @return self
     */
    public function apply($config)
    {
        if (false === is_callable($config)) {
            $config = $this->injector->make($config);
        }

        $config($this->injector);

        return $this;
    }

    /**
     * Apply a list of configurations to the injector
     *
     * @param array $configs
     *
     * @return self
     */
    public function configure(array $configs)
    {
        \array_map([$this, 'apply'], $configs);

        return $this;
    }

    /**
     * Fetch the injector
     *
     * @return Injector
     */
    public function injector()
    {
        return $this->injector;
    }
}
