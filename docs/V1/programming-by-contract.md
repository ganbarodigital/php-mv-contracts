---
currentSection: v1
currentItem: home
pageflow_prev_url: index.html
pageflow_prev_text: V1 Overview
---

# Programming By Contract

## What Is Programming By Contract?

_Programming by contract_ is a _correctness_ approach built on a 3-step scientific process:

1. __require__ that all pre-conditions are met
1. __do__ the work
1. __ensure__ that all post-conditions are met

_Pre-conditions_ and _post-conditions_ can include:

* input parameter validation
* return value validation
* checking that expected side effects have occurred
* checking that invariants haven't changed

Checks can also be made whilst the module / function / method is doing the work.

## Why Is Programming By Contract A Good Idea?

_Programming by contract_ builds __proven correctness__ into the code that you ship:

* the method _requires that_ certain things (pre-conditions) are true before you call the method,
* when the method returns, the method _ensures that_ certain things (post-conditions) are true
* if the method cannot guarantee that the post-conditions are met, it throws an exception

This approach catches errors in your code as early as possible.

<div class="callout info">
The greater the distance between when an error occurred and where an error is detected, the harder it is to correctly identify the real cause of the error.
</div>

_Programming by contract_ moves responsibility for correctness from your unit tests and into the code that you ship. This makes it a lot easier for other developers to know that they're using your code safely.

<div class="callout info" markdown="1">
With _programming by contract_, unit tests become responsible for exercising the code and documenting all of the features and functionality that your code provides.
</div>

<div class="callout info" markdown="1">
With _programming by contract_, your correctness tests are also there when your code goes through functional and non-functional testing. That's something you can't get by placing the burden of proof on your unit tests alone.
</div>

## Why Is Programming By Contract Different From Input Validation?

Most widely-used robustness approaches focus primarily on validating inputs. This is often driven by security concerns (preventing data breaches, preventing the host being compromised, preventing denial-of-service). These are all important activities, but they are examples of _non-functional requirements_.

__They're not driven by ensuring that the delivered code actually works.__

### Separating Robustness From Correctness

Separate out the expectations and guarantees into two distinct layers:

* variable types (robustness)
* application state / business rules met (correctness)

Use PHP's type-checking support to perform robustness checks. PHP 7 is a major step forward in this area. Use inspection / reflection libraries like our own [Reflection Library](https://ganbarodigital.github.io/php-mv-reflection/) to plug gaps in what the language can check. Implement robustness checks on every `public` method.

## What Contracts To Define And Where

Limit your correctness checks to the context where the contract is being enforced. For example, an API library should not attempt to enforce any contract about business logic.

Code Type      | Robustness? | Correctness?
---------------|-------------|-------------
Library        | Yes         | Library state only
Framework      | Yes         | Framework state only
Controllers    | Yes         | Application route only
Business Logic | Yes         | Business rules only
Data Layer     | Yes         | Data integrity only
Views          | Yes         | No

If you add contracts that check things they have no business knowing about, you'll find that the contracts get in the way of reusing your code. Getting the balance right takes time and experience.


## Meeting Expectations

Use the `Contracts` class to check pre-conditions and post-conditions:

```php
use GanbaroDigital\Contracts\V1\Contracts;

function cancelDirectDebit(DirectDebit $mandate)
{
    // correctness!
    Contracts::requireThat(function() use ($mandate) {
        Contracts::assertValue($mandate, !$mandate->isCancelled(), "mandate is already cancelled");
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

## Fail Early, Fail Hard

When an expectation is not met, an exception is thrown straight away. Errors are caught as soon as possible, and invalid values are not allowed to propagate through your application. The idea here is to make sure that bugs in your code are identified as quickly as possible.

<div class="callout info">
The greater the distance between when an error occurred and where an error is detected, the harder it is to correctly identify the real cause of the error.
</div>

If you're the kind of programmer who does this:

```php
try {
    // do something ...
}
catch (\Exception $e) {
    // log exception
    // do nothing
}
```

then you'll get limited benefits from _programming by contract_. The same is true if your app consumes a lot of libraries which catch all exceptions - especially if they're silently swallowing errors.
