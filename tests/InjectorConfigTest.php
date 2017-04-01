<?php

namespace Cairon;

use Auryn\Injector;
use PHPUnit\Framework\TestCase;

class InjectorConfigTest extends TestCase
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @var InjectorConfig
     */
    private $config;

    public function setUp()
    {
        $this->injector = new Injector();
        $this->config = InjectorConfig::make($this->injector);
    }

    public function testApply()
    {
        $this->config->apply(Fixture\Config::class);

        $a = $this->injector->make(Fixture\Shared::class);
        $b = $this->injector->make(Fixture\Shared::class);

        $this->assertSame($a, $b);
    }

    public function testConfigure()
    {
        $names = [
            Fixture\Config::class,
        ];

        $this->config->configure($names);

        $a = $this->injector->make(Fixture\Shared::class);
        $b = $this->injector->make(Fixture\Shared::class);

        $this->assertSame($a, $b);
    }

    public function testInjector()
    {
        $injector = $this->config->injector();

        $this->assertSame($this->injector, $injector);

        // If no injector is defined, a new one is constructed
        $injector = (new InjectorConfig())->injector();

        $this->assertInstanceOf(Injector::class, $injector);
    }
}
