<?php

/**
 * Copyright (c) 2011-2016 Stuart Herbert
 * Copyright (c) 2016-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   Contracts/V1/Contracts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2011-2016 Stuart Herbert www.stuartherbert.com
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-contracts
 */

namespace GanbaroDigital\Contracts\V1;

use GanbaroDigital\Contracts\V1\Contracts\AssertValue;
use GanbaroDigital\Contracts\V1\Contracts\CheckContracts;
use GanbaroDigital\Contracts\V1\Contracts\ContractChecks;

/**
 * entry point for working with contracts
 */
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
    public static function enableContracts()
    {
        ContractChecks::enable();
    }

    /**
     * tell the Contracts Library *not* to check the contracts in the
     * '::requireThat()', '::ensureThat()' and '::checkThat()' methods
     *
     * @return void
     */
    public static function disableContracts()
    {
        ContractChecks::disable();
    }

    /**
     * are the '::requireThat()', '::ensureThat()' and '::checkThat()' methods
     * enforcing their contacts?
     *
     * @return boolean
     *         TRUE if these methods run their contacts
     *         FALSE if these methods skip over their contracts
     */
    public static function areContractsEnabled()
    {
        return ContractChecks::areEnabled();
    }

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
    public static function requireThat($callback, $params = [])
    {
        CheckContracts::now($callback, $params);
    }

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
    public static function ensureThat($callback, $params = [])
    {
        CheckContracts::now($callback, $params);
    }

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
    public static function checkThat($callback, $params = [])
    {
        CheckContracts::now($callback, $params);
    }

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
    public static function assertValue($value, $expr, $reason = null)
    {
        AssertValue::apply($expr, $reason)->to($value);
    }

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
    public static function forAll($values, $callback)
    {
        array_walk($values, $callback);
        return true;
    }
}
