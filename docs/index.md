---
currentSection: overview
currentItem: home
pageflow_next_url: license.html
pageflow_next_text: License
---

# Introduction

## What Is The Contracts Library?

Ganbaro Digital's _Contracts Library_ provides support for _programming by contract_ to help you prove the correctness of your own code.

## Goals

The _Contracts Library_'s purpose is to collect correctness tools and approaches:

* programming by contract - checking inputs and outputs to prove that an algorithm works as intended

## Design Constraints

The library's design is guided by the following constraint(s):

* _Fundamental dependency of other libraries_: This library provides robustness tests for other libraries to use in production. Composer does not support multual dependencies (two or more packages depending on each other). As a result, this library needs to depend on very little (if anything at all).

## Questions?

This package was created by [Stuart Herbert](http://www.stuartherbert.com) for [Ganbaro Digital Ltd](http://ganbarodigital.com). Follow [@ganbarodigital](https://twitter.com/ganbarodigital) or [@stuherbert](https://twitter.com/stuherbert) for updates.
