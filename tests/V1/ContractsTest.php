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

namespace GanbaroDigitalTest\Contracts\V1;

use GanbaroDigital\Contracts\V1\Contracts;
use PHPUnit_Framework_TestCase;
use GanbaroDigital\Contracts\V1\Contracts\ContractChecks;

/**
 * @coversDefaultClass GanbaroDigital\Contracts\V1\Contracts
 */
class ContractsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::enableContracts
     */
    public function testCanEnableContracts()
    {
        // ----------------------------------------------------------------
        // setup your test

        ContractChecks::disable();
        $this->assertFalse(ContractChecks::areEnabled());
        $this->assertFalse(Contracts::areContractsEnabled());

        // ----------------------------------------------------------------
        // perform the change

        Contracts::enableContracts();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(ContractChecks::areEnabled());
        $this->assertTrue(Contracts::areContractsEnabled());
    }

    /**
     * @covers ::disableContracts
     */
    public function testCanDisableContracts()
    {
        // ----------------------------------------------------------------
        // setup your test

        ContractChecks::enable();
        $this->assertTrue(ContractChecks::areEnabled());
        $this->assertTrue(Contracts::areContractsEnabled());

        // ----------------------------------------------------------------
        // perform the change

        Contracts::disableContracts();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(ContractChecks::areEnabled());
        $this->assertFalse(Contracts::areContractsEnabled());
    }

    /**
     * @covers ::areContractsEnabled
     */
    public function testCanCheckThatContractsAreEnabled()
    {
        // ----------------------------------------------------------------
        // setup your test

        ContractChecks::enable();
        $this->assertTrue(ContractChecks::areEnabled());
        $this->assertTrue(Contracts::areContractsEnabled());

        // ----------------------------------------------------------------
        // perform the change

        ContractChecks::disable();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(ContractChecks::areEnabled());
        $this->assertFalse(Contracts::areContractsEnabled());
    }

    /**
     * @covers ::requireThat
     */
    public function testCanRequireThatPreConditionsAreMet()
    {
        // ----------------------------------------------------------------
        // setup your test

        $executed = false;
        $callback = function() use (&$executed) {
            $executed = true;
        };
        Contracts::enableContracts();

        // ----------------------------------------------------------------
        // perform the change

        Contracts::requireThat($callback, []);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($executed);
    }

    /**
     * @covers ::ensureThat
     */
    public function testCanEnsureThatPostConditionsAreMet()
    {
        // ----------------------------------------------------------------
        // setup your test

        $executed = false;
        $callback = function() use (&$executed) {
            $executed = true;
        };

        // ----------------------------------------------------------------
        // perform the change

        Contracts::ensureThat($callback, []);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($executed);
    }

    /**
     * @covers ::checkThat
     */
    public function testCanCheckWorkInProgress()
    {
        // ----------------------------------------------------------------
        // setup your test

        $executed = false;
        $callback = function() use (&$executed) {
            $executed = true;
        };

        // ----------------------------------------------------------------
        // perform the change

        Contracts::checkThat($callback, []);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($executed);
    }

    /**
     * @covers ::assertValue
     */
    public function testCanAssertAValue()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        Contracts::assertValue(5, 5 > 4);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, all is well
    }

    /**
     * @covers ::assertValue
     * @dataProvider provideFailedExpressions
     * @expectedException GanbaroDigital\Contracts\V1\Exceptions\ContractFailed
     */
    public function test_throws_exception_if_AssertValue_expression_is_not_true($expr)
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 5;

        // ----------------------------------------------------------------
        // perform the change

        Contracts::assertValue($value, $expr);
    }

    /**
     * @covers ::forAll
     */
    public function test_can_apply_a_check_to_all_values()
    {
        // ----------------------------------------------------------------
        // setup your test

        $values = [
            10, 9, 8, 7, 6, 100, 1000
        ];
        $seen = [];

        // ----------------------------------------------------------------
        // perform the change

        Contracts::forAll($values, function($value) use(&$seen) { $seen[] = $value; });

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($values, $seen);
    }

    public function provideFailedExpressions()
    {
        return [
            [ false ],
            [ 5 > 6 ],
        ];
    }
}
