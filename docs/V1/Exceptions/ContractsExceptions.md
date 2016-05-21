---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: ContractFailed.html
pageflow_prev_text: ContractFailed class
---

# ContractsExceptions

<div class="callout info">
Since v1.2016052101
</div>

## Description

`ContractsExceptions` is a [`FactoryList`](http://ganbarodigital.github.io/php-mv-di-containers/V1/Interfaces/FactoryList.html). It provides factory methods for all exceptions that the _Contracts Library_ can throw.

## Public Interface

`ContractsExceptions` has the following public interface.

```php
// ContractsExceptions lives in this namespace
namespace GanbaroDigital\Contracts\V1\Exceptions;

// our base classes and interfaces
use GanbaroDigital\DIContainers\V1\FactoryList\Containers\FactoryListContainer;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class ContractsExceptions extends FactoryListContainer
{
    public function __construct();

    /**
     * return the full list of factories as a real PHP array
     *
     * @return array
     * @inheritedFrom FactoryList
     */
    public function getList();
}
```

## How To Use

### Construction

Here's how to build a new instance of `ContractsExceptions`.

```php
use GanbaroDigital\Contracts\V1\Exceptions\ContractsExceptions;

$diContainer = new ContractsExceptions;
```

### Creating A New Exception

Treat `ContractsExceptions` as a PHP array that contains factory methods. Each factory's name is the same _class::method_ that you would use to call the exception's factory directly.

```php
use GanbaroDigital\Contracts\V1\Exceptions\ContractsExceptions;

$diContainer = new ContractsExceptions;

throw $diContainer['ContractFailed::newFromBadValue'](false);
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Contracts\V1\Exceptions\ContractsExceptions
     [x] Can instantiate
     [x] Is factory list
     [x] has factory for ContractFailed newFromBadValue

Class contracts are built from this class's unit tests.

<div class="callout success">
Future releases of this class will not break this contract.
</div>

<div class="callout info" markdown="1">
Future releases of this class may add to this contract. New additions may include:

* clarifying existing behaviour (e.g. stricter contract around input or return types)
* add new behaviours (e.g. extra class methods)
</div>

<div class="callout warning" markdown="1">
When you use this class, you can only rely on the behaviours documented by this contract.

If you:

* find other ways to use this class,
* or depend on behaviours that are not covered by a unit test,
* or depend on undocumented internal states of this class,

... your code may not work in the future.
</div>

## Notes

None at this time.
