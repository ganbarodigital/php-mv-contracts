---
currentSection: v1
currentItem: Contracts
pageflow_prev_url: index.html
pageflow_prev_text: Contracts
pageflow_next_url: CheckContracts.html
pageflow_next_text: CheckContracts class
---

# AssertValue

<div class="callout info">
Since v1.2016052101
</div>

## Description

`AssertValue` is a [`Requirement`](http://ganbarodigital.github.io/php-mv-defensive/V1/Interfaces/Requirement.html). It throws a [`ContractFailed`](../Exceptions/ContractFailed.html) exception if an expression does not evaluate to `true`.

## Public Interface

`AssertValue` has the following public interface:

```php
// AssertValue lives in this namespace
namespace GanbaroDigital\Contracts\V1\Contracts;

// our base classes and interfaces
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;

// our exceptions
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;

/**
 * check that an expression is true ... and if it is not, throw an exception
 */
class AssertValue implements Requirement
{
    /**
     * create a composable requirement
     *
     * @param  boolean $expr
     *         the expression we use to check $value
     * @param  string|null $reason
     *         the reason why $expr must be true
     * @return Requirement
     *         a requirement that can be enforced
     */
    public static function apply($expr, $reason = null);

    /**
     * constructor
     *
     * @param  boolean $expr
     *         the expression we are checking
     * @param  string|null $reason
     *         the reason why $expr must be true
     * @return boolean
     *         TRUE on success
     */
    public function __construct($expr, $reason = null);

    /**
     * check that an expression is true ... and if it is not, throw an
     * exception
     *
     * @param  mixed $data
     *         the value check we are checking
     * @param  string $fieldOrVarName
     *         the name of the field we are checking
     * @return boolean
     *         TRUE on success
     */
    public function __invoke($data, $fieldOrVarName = 'value');

    /**
     * check that an expression is true ... and if it is not, throw an
     * exception
     *
     * @param  mixed $data
     *         the value check we are checking
     * @param  string $fieldOrVarName
     *         the name of the field we are checking
     * @return boolean
     *         TRUE on success
     */
    public function to($data, $fieldOrVarName = 'value');
}
```

## How To Use

### Enforcing A Contract

Use the `::apply()->to()` pattern to check a value:

```php
use GanbaroDigital\Contracts\V1\Contracts\AssertValue;

$data = 10;
AssertValue::apply($data > 4)->to($data);
```

If the expression does not evaluates to `true`, an exception is thrown:

```php
use GanbaroDigital\Contracts\V1\Contracts\AssertValue;

// throws a ContractFailed exception
$data = 2;
AssertValue::apply($data > 4)->to($data);
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Contracts\V1\Contracts\AssertValue
     [x] Can instantiate
     [x] is Requirement
     [x] Returns true if expression is true
     [x] Throws exception if expression is not true

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

### Combining AssertValue With PHP's assert()

PHP 5 and PHP 7 have [`assert()`](http://php.net/manual/en/function.assert.php) functions that behave differently:

* PHP 5's `assert()` (by default) raises a legacy PHP warning
* PHP 7's `assert()` can be told to thrown an exception, but you have to provide it each time

Both PHP 5 and PHP 7 support disabling `assert()` to increase performance in Production.

* In PHP 5, any expression passed to `assert()` is still evaluated first, unless you pass the expression as a string (which quickly gets very horrible to maintain).
* In PHP 7, the expression is not evaluated. Disabled assertions are (effectively) commented out.

`AssertValue` can be combined with PHP's `assert()` safely:

```php
$data = 10;
assert(AssertValue::apply($data > 5)->to($data));
```

That will work on PHP 5 and PHP 7, and bring you these benefits:

1. Ease of use: can pass any PHP expression, no need to pass it as as string
2. Stricter: the expression has to evaluate to `true`, anything else is treated as a failure
3. Modern error flow: `AssertValue` throws an exception, no need to deal with PHP's legacy error system
4. Better error information: the `ContractFailed` exception contains `$data`'s value and type

On PHP 5, switching off assertions will not improve the speed of your code. `AssertValue` will still run, and it will still throw an exception if the expression isn't `true`.

## See Also

* [`Requirement` interface](http://ganbarodigital.github.io/php-mv-defensive/V1/Interfaces/Requirement.html)
