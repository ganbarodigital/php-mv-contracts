---
currentSection: v1
currentItem: contracts
pageflow_prev_url: ContractChecks.html
pageflow_prev_text: ContractChecks
---

# Contracts

<div class="callout info">
Since v1.2016052101
</div>

## Description

`Contracts` provides support for adding _programming by contract_ to your own code.

It's a convenience wrapper around all of the functionality defined by the _Contracts Library_.

## Public Interface

`Contracts` has the following public interface:

```php
// Contracts lives in this namespace
namespace GanbaroDigital\Contracts\V1;

class Contracts
{
    // ====================================================================
    //
    // contract checking
    //
    // --------------------------------------------------------------------

    /**
     * tell the Contracts Library to check the contracts in the
     * '::requireThat()', '::ensureThat()' and '::checkThat()' methods
     *
     * @return void
     */
    public static function enableContracts();

    /**
     * tell the Contracts Library *not* to check the contracts in the
     * '::requireThat()', '::ensureThat()' and '::checkThat()' methods
     *
     * @return void
     */
    public static function disableContracts();

    /**
     * are the '::requireThat()', '::ensureThat()' and '::checkThat()' methods
     * enforcing their contacts?
     *
     * @return boolean
     *         TRUE if these methods run their contacts
     *         FALSE if these methods skip over their contracts
     */
    public static function areContractsEnabled();

    // ====================================================================
    //
    // require / check / ensure
    //
    // --------------------------------------------------------------------

    /**
     * check a set of contract terms *if* we are enforcing wrapped contracts
     *
     * use this at the start of your function / method to make sure that
     * all of your pre-conditions are met before you do anything else
     *
     * @param  callable $callback
     *         function to call to check the set of contract terms
     * @param  array $params
     *         a list of parameters to pass into $callback
     * @return boolean
     *         TRUE on success
     */
    public static function requireThat($callback, $params = []);

    /**
     * check a set of contract terms *if* we are enforcing wrapped contracts
     *
     * use this at the end of your function / method to make sure that
     * all of your post-conditions are met before you do anything else
     *
     * @param  callable $callback
     *         function to call to check the set of contract terms
     * @param  array $params
     *         a list of parameters to pass into $callback
     * @return boolean
     *         TRUE on success
     */
    public static function ensureThat($callback, $params = []);

    /**
     * check a set of contract terms *if* we are enforcing wrapped contracts
     *
     * use this in the middle of your logic to make sure that you're happy
     * with everything up to this point
     *
     * @param  callable $callback
     *         function to call to check the set of contract terms
     * @param  array $params
     *         a list of parameters to pass into $callback
     * @return boolean
     *         TRUE on success
     */
    public static function checkThat($callback, $params = []);

    // ====================================================================
    //
    // individual contract terms
    //
    // --------------------------------------------------------------------

    /**
     * check that an expression is true ... and if it is not, throw an
     * exception
     *
     * @param  mixed $value
     *         the value check we are checking
     * @param  boolean $expr
     *         the expression we use to check $value
     * @param  string|null $reason
     *         the reason why $expr must be true
     * @return boolean
     *         TRUE on success
     */
    public static function assertValue($value, $expr, $reason = null);

    /**
     * apply the same set of contracts to all the values in an array
     *
     * @param  array $values
     *         the list of values to check
     * @param  callable $callback
     *         the contracts to apply, as a function
     * @return boolean
     *         TRUE on success
     */
    public static function forAll($values, $callback);
}
```

## How To Use

### Enabling / Disabling Contract Checking

Call `Contracts::enableContracts()` and `Contracts::disableContracts()` to enable or disable contract checking.

```php
use GanbaroDigital\Contracts\V1\Contracts;

// switch contracts on
Contracts::enableContracts();

// switch them off again
Contracts::disableContracts();
```

### Checking If Contracts Are Enabled

Call `Contracts::areContractsEnabled()` to discover if contracts are enabled or not:

```php
use GanbaroDigital\Contracts\V1\Contracts;

// will output 'true' or 'false'
var_dump(Contracts::areContractsEnabled());
```

### Checking Contracts

Use `Contracts::assertValue()` to check an individual contract term. Wrap them up in a function, and pass that to `Contracts::requireThat()` or `Contracts::ensureThat()` to check the contract terms.

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
        Contracts::assertValue($mandate, $mandate->isCancelled(), "failed to cancel mandate");
    });
}
```

If contract checking is disabled, `Contracts::requireThat()` and `Contracts::ensureThat()` will not attempt to execute the function you pass to them.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Contracts\V1\Contracts
     [x] Can enable contracts
     [x] Can disable contracts
     [x] Can check that contracts are enabled
     [x] Can require that pre conditions are met
     [x] Can ensure that post conditions are met
     [x] Can check work in progress
     [x] Can assert a value
     [x] throws exception if AssertValue expression is not true
     [x] can apply a check to all values

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

### Recommended Interface

`Contracts` is the recommended interface to call from your code.

Internally, `Contracts` uses the [`AssertValue`](AssertValue.html), [`CheckContracts`](CheckContracts.html) and [`ContractChecks`](ContractChecks.html) classes. You can safely call these classes directly if you want to.
