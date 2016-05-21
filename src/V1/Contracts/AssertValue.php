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

namespace GanbaroDigital\Contracts\V1\Contracts;

use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement;

/**
 * check that an expression is true ... and if it is not, throw an exception
 */
class AssertValue implements Requirement
{
    // save us having to define ::__invoke() ourselves
    use InvokeableRequirement;

    /**
     * the result of the expression that is being tested
     *
     * @var boolean
     */
    private $expr;

    /**
     * an explanation of why the assertion failed
     *
     * @var string|null
     */
    private $reason;

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
    public static function apply($expr, $reason = null)
    {
        return new static($expr, $reason);
    }

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
    public function __construct($expr, $reason = null)
    {
        $this->expr = $expr;
        $this->reason = $reason;
    }

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
    public function to($data, $fieldOrVarName = 'value')
    {
        if ($this->expr !== true) {
            throw ContractFailed::newFromBadValue($data, $this->reason);
        }

        return true;
    }
}
