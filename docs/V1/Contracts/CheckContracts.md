---
currentSection: v1
currentItem: contracts
pageflow_prev_url: AssertValue.html
pageflow_prev_text: AssertValue class
pageflow_next_url: ContractChecks.html
pageflow_next_text: ContractChecks class
---

# CheckContracts

<div class="callout warning">
Not yet in a tagged release
</div>

## Description

`CheckContracts` will check a set of contracts, if and only if contract checking is enabled. If contract checking is disabled, the contracts will not be checked.

This reduces (but does not completely eliminate) the performance overhead when you switch off contract checking in your code.

## Public Interface

`CheckContracts` has the following public interface:

```php
// CheckContracts lives in this namespace
namespace GanbaroDigital\Contracts\V1\Contracts;

class CheckContracts
{
    /**
     * check a set of contract terms *if* contract checking is enabled
     *
     * @param  callable $callback
     *         function to call to check the set of contract terms
     * @param  array $params
     *         a list of parameters to pass into $callback
     * @return boolean
     *         TRUE on success
     */
    public static function now($callback, $params = []);
}
```

## How To Use

### Checking Contracts

Use `CheckContracts::now()` to check a set of contracts.

```php
use GanbaroDigital\Contracts\V1\Contracts\CheckContracts;

function cancelDirectDebit(DirectDebit $mandate)
{
    // correctness!
    CheckContracts::now(function() use ($mandate) {
        Contracts::assertValue($mandate, !$mandate->isCancelled(), "mandate is already cancelled");
        Contracts::assertValue($mandate, !$mandate->isDeleted(), "mandate has been deleted");
    });

    // if we get here, then all contracts have been made
}
```

In this example, we've put all of our contracts into a single anonymous function. That way, if we ever decide to disable contract checking, we save a lot of performance.

### Via The Contracts Class

The [`Contracts`](Contracts.html) class is a more convenient way to check contracts from your code:

```php
use GanbaroDigital\Contracts\V1\Contracts;

function cancelDirectDebit(DirectDebit $mandate)
{
    // correctness!
    Contracts::requireThat(function() use ($mandate) {
        Contracts::assertValue($mandate, !$mandate->isCancelled(), "mandate is already cancelled");
        Contracts::assertValue($mandate, !$mandate->isDeleted(), "mandate has been deleted");
    });

    // cancel the mandate here
    //
    // it isn't the API client's role to check whether or not a mandate should
    // be cancelled ... it's just going to pass through the details to the
    // remote API
    $this->apiClient->cancelMandate($mandate);

    // correctness!
    Contracts::ensureThat(function() use ($mandate) {
        Contracts::assertValue($mandate, $mandate->isCancelled(), "unable to cancel mandate");
    });
}
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
