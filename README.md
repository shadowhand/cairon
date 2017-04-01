# cairon

A tiny wrapper around an [auryn](https://github.com/rdlowrey/auryn) that provides
configuration capabilities.

> Like auryn, cairon should never be used as a Service Locator!

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

The only requirement for the [callable](http://php.net/manual/en/language.types.callable.php)
is that it accept an instance of `Auryn\Injector` as the first and only argument:

```
fn(Injector $injector): void
```

_**Note:** If the provided configuration is not currently callable, it is assumed
to be a class name and will be resolved by calling `Injector::make()`._

### Existing Injector

If you already have an instance of `Auryn\Injector` it can be provided to the constructor:

```php
$injector = new Injector();

$config = InjectorConfig::make($injector);

assert($injector === $config->injector());
```

# License

MIT.
