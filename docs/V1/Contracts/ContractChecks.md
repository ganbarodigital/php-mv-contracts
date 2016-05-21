---
currentSection: v1
currentItem: contracts
pageflow_prev_url: CheckContracts.html
pageflow_prev_text: CheckContracts class
---

# ContractChecks

<div class="callout warning">
Not yet in a tagged release
</div>

## Description

`ContractChecks` allows you to enable or disable the _Contract Library's_ contracts at any time.

## Public Interface

`ContractChecks` has the following public interface:

```php
// ContractChecks lives in this namespace
namespace GanbaroDigital\Contracts\V1\Contracts;

class ContractChecks
{
    /**
     * reset contract checking to its default state
     *
     * this has been added for unit testing purposes
     * 
     * @return void
     */
    public static function resetToDefaults();

    /**
     * are contract checks currently enabled?
     *
     * @return boolean
     */
    public static function areEnabled();

    /**
     * switch on checking of contracts
     *
     * @return void
     */
    public static function enable();

    /**
     * switch off checking of contracts
     *
     * @return void
     */
    public static function disable();
}
```

## How To Use

### Check If Contracts Are Enabled

Use `ContractChecks::areEnabled()` to see if contract checking is currently disabled or not:

```php
use GanbaroDigital\Contracts\V1\Contracts\ContractChecks;

// will be 'true' if enabled, 'false' otherwise
var_dump(ContractChecks::areEnabled());
```

Other classes in the _Contracts Library_ will check this for you. Other than for diagnostic purposes, there's no reason to check this from code outside of the _Contracts Library_.

### Enable / Disable Contracts

You might want to disable contract checking for performance reasons. In your unit tests, you might want to make sure that contracts are definitely being checked.

```php
use GanbaroDigital\Contracts\V1\Contracts\ContractChecks;

// switch contract checking on
ContractChecks::enable();

// and switch it off again
ContractChecks::disable();
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Contracts\V1\Contracts\ContractChecks
     [x] Contract checks are enabled by default
     [x] Can reset to defaults
     [x] Can enable contract checks
     [x] Can disable contract checks
     [x] Can check if contract checks are enabled

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
