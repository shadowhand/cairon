# cairon

A tiny wrapper around an [auryn][auryn] that provides configuration capabilities.

> Like auryn, cairon should never be used as a Service Locator!

[auryn]: https://github.com/elazar/auryn-configuration

## Usage

The basic purpose of cairon is to apply callable configurations to auryn.

This is done using either `configure()` with a list of callables, or `apply()`
with a single callable.

```php
use Auryn\Injector;
use Cairon\InjectorConfig;

$injector = InjectorConfig::make()
    ->configure([
        Acme\Injector\Foo::class,
        ['SomeClass::staticMethod']
        function (Injector $injector) { /* ... */ }
        // ...
    ])
    ->apply([$someObject, 'method'])
    ->injector();
```

### Callables

The only requirement for the [callable][callable] is that it accept an instance
of `Auryn\Injector` as the first and only argument:

```
fn(Injector $injector): void
```

_**Note:** If the provided configuration is not currently callable, it is assumed
to be a class name and will be resolved by calling `Injector::make()`._

[callable]: https://github.com/elazar/auryn-configuration

### Best Practice

The preferred approach to using cairon is by creating a closure that is included.
This removes the need to create a concrete class for configuration and promotes
the idea that auryn is only used in bootstrapping.

For example, we could create `config/injection/psr7.php`:

```php
use Auryn\Injector;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;

return function (Injector $injector) {
    $injector->alias(ServerRequestInterface::class, ServerRequest::class);
    $injector->delegate(ServerRequestInterface::class, 'ServerRequestFactory::fromGlobals');
};
```

And then apply it in our bootstrap:

```php
use Cairon\InjectorConfig;

$injector = InjectorConfig::make()
    ->configure([
        require __DIR__ . '/config/injection/psr7.php',
    ])
    ->injector();
```

### Existing Injector

If you already have an instance of `Auryn\Injector` it can be provided to the constructor:

```php
$injector = new Injector();

$config = InjectorConfig::make($injector);

assert($injector === $config->injector());
```

# Inspiration

The theory behind cairon comes from [elazar/auryn-configuration][auryn-configuration].
This same theory was also adopted by [equip/config][equip-config]. My goal was to
simplify the theory into a wrapper that could be used with any callable, without
implementing a concrete interface.

[auryn-configuration]: https://github.com/elazar/auryn-configuration
[equip-config]: https://github.com/equip/config

# License

MIT.
