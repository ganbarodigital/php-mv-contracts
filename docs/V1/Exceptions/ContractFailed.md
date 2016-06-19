---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: index.html
pageflow_prev_text: Contracts
pageflow_next_url: ContractsExceptions.html
pageflow_next_text: ContractsExceptions class
---

# ContractFailed

<div class="callout info">
Since v1.2016052101
</div>

## Description

`ContractFailed` is an exception. It is thrown when one of the contract assertions evaluates to `false`.

## Public Interface

`ContractFailed` has the following public interface:

```php
// ContractFailed lives in this namespace
namespace GanbaroDigital\Contracts\V1\Exceptions;

// our base classes and interfaces
use GanbaroDigital\Contracts\V1\Exceptions\ContractsException;
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;
use GanbaroDigital\HttpStatus\StatusProviders\RuntimeError\UnexpectedErrorStatusProvider;

// return type(s) for our methods
use GanbaroDigital\HttpStatus\StatusValues\RuntimeError\UnexpectedErrorStatus;

class ContractFailed
  extends ParameterisedException
  implements ContractsException, HttpRuntimeErrorException
{
    // we map onto HTTP 500
    use UnexpectedErrorStatusProvider;

    // default values for extra data
    static protected $defaultExtras = [
        'reason' => 'no reason provided',
    ];

    /**
     * create a new exception when a value fails a contract
     *
     * @param  mixed $fieldOrVar
     *         the value that you're throwing an exception about
     * @param  string $fieldOrVarName
     *         the name of the value in your code
     * @param  array $extraData
     *         extra data that you want to include in your exception
     * @param  int|null $typeFlags
     *         do we want any extra type information in the final
     *         exception message?
     * @param  array $callStackFilter
     *         are there any namespaces we want to filter out of
     *         the call stack?
     * @return ContractFailed
     *         an fully-built exception for you to throw
     */
    public static function newFromVar(
        $fieldOrVar,
        $fieldOrVarName,
        array $extraData = [],
        $typeFlags = null,
        array $callStackFilter = []
    );

    /**
     * what was the data that we used to create the printable message?
     *
     * @return array
     */
    public function getMessageData();

    /**
     * what was the format string we used to create the printable message?
     *
     * @return string
     */
    public function getMessageFormat();

    /**
     * which HTTP status code do we map onto?
     *
     * @return UnexpectedErrorStatus
     */
    public function getHttpStatus();
}
```

## How To Use

### Creating Exceptions To Throw

Call `ContractFailed::newFromVar()` to create a new throwable exception:

```php
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;

$arg1 = null;
throw ContractFailed::newFromVar(
    $arg1,
    '$arg1',
    [ 'reason' => 'cannot be null']
);
```

### Catching The Exception

`ContractFailed` implements a rich set of classes and interfaces. You can use any of these to `catch` this exception.

```php
// example 1: we catch only ContractFailed exceptions
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;

try {
    $arg1 = null;
    throw ContractFailed::newFromVar(
        $arg1,
        '$arg1',
        [ 'reason' => 'cannot be null']
    );
}
catch(BadRequirements $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Contracts Library
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use GanbaroDigital\Contracts\V1\Exceptions\ContractsException;

try {
    $arg1 = null;
    throw ContractFailed::newFromVar(
        $arg1,
        '$arg1',
        [ 'reason' => 'cannot be null']
    );
}
catch(ContractsException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was an unexpected problem
// at runtime
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;

try {
    $arg1 = null;
    throw ContractFailed::newFromVar(
        $arg1,
        '$arg1',
        [ 'reason' => 'cannot be null']
    );
}
catch(HttpRuntimeErrorException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use GanbaroDigital\HttpStatus\Interfaces\HttpException;

try {
    $arg1 = null;
    throw ContractFailed::newFromVar(
        $arg1,
        '$arg1',
        [ 'reason' => 'cannot be null']
    );
}
catch(HttpException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use RuntimeException;

try {
    $arg1 = null;
    throw ContractFailed::newFromVar(
        $arg1,
        '$arg1',
        [ 'reason' => 'cannot be null']
    );
}
catch(RuntimeException $e) {
    // ...
}
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Contracts\V1\Exceptions\ContractFailed
     [x] Can instantiate
     [x] is ContractsException
     [x] is ParameterisedException
     [x] is HttpRuntimeErrorException
     [x] maps to HTTP 500 UnexpectedError
     [x] is RuntimeException
     [x] Can create from PHP variable

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

## See Also

* [`ParameterisedException` class](http://ganbarodigital.github.io/php-mv-exception-helpers/V1/BaseExceptions/ParameterisedException.html)
* [mapping exceptions onto HTTP status codes](http://ganbarodigital.github.io/php-http-status/usage/http-exceptions.html)
