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

namespace GanbaroDigitalTest\Contracts\V1\Contracts;

use GanbaroDigital\Contracts\V1\Contracts\AssertValue;
use GanbaroDigital\Contracts\V1\Exceptions\ContractFailed;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use PHPUnit_Framework_TestCase;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Values\CodeCaller;

/**
 * @coversDefaultClass GanbaroDigital\Contracts\V1\Contracts\AssertValue
 */
class AssertValueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new AssertValue(false, '');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(AssertValue::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_Requirement()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new AssertValue(false, '');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Requirement::class, $unit);
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testReturnsTrueIfExpressionIsTrue()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        AssertValue::apply(5 > 4)->to(5);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, all is well
    }

    /**
     * @covers ::apply
     * @covers ::to
     * @dataProvider provideFailedExpressions
     * @expectedException GanbaroDigital\Contracts\V1\Exceptions\ContractFailed
     */
    public function testThrowsExceptionIfExpressionIsNotTrue($expr)
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 5;

        // ----------------------------------------------------------------
        // perform the change

        AssertValue::apply($expr)->to($value);
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testFailedAssertProvidesLocationOfBrokenContract()
    {
        // ----------------------------------------------------------------
        // setup your test
        //
        // we care about
        // - message
        // - thrownByName
        // - thrownBy

        $value = 5;
        $reason = "must be less than 4";
        $e = null;

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 14) . ': contract failed; ' . $reason;
        $expectedData = [
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 12),
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, __LINE__ + 11),
            'fieldOrVar' => $value,
            'fieldOrVarName' => 'value',
            'reason' => $reason,
            'dataType' => 'integer<' . $value . '>'
        ];

        // ----------------------------------------------------------------
        // perform the change

        try {
            AssertValue::apply($value < 4, $reason)->to($value);
        }
        catch (ContractFailed $e) {
            // do nothing
        }

        // ----------------------------------------------------------------
        // test the results

        // make sure we caught an exception
        $this->assertInstanceOf(ContractFailed::class, $e);

        // make sure it has the details we expect
        $actualMessage = $e->getMessage();
        $actualData = $e->getMessageData();

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testFailedAssertProvidesContractTerms()
    {
        // ----------------------------------------------------------------
        // setup your test
        //
        // we care about:
        // - message
        // - reason

        $value = 5;
        $reason = "must be less than 4";
        $e = null;

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 14) . ': contract failed; ' . $reason;
        $expectedData = [
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 12),
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, __LINE__ + 11),
            'fieldOrVar' => $value,
            'fieldOrVarName' => 'value',
            'reason' => $reason,
            'dataType' => 'integer<' . $value . '>'
        ];

        // ----------------------------------------------------------------
        // perform the change

        try {
            AssertValue::apply($value < 4, $reason)->to($value);
        }
        catch (ContractFailed $e) {
            // do nothing
        }

        // ----------------------------------------------------------------
        // test the results

        // make sure we caught an exception
        $this->assertInstanceOf(ContractFailed::class, $e);

        // make sure it has the details we expect
        $actualMessage = $e->getMessage();
        $actualData = $e->getMessageData();

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testFailedAssertFallsBackToDefaultContractTerms()
    {
        // ----------------------------------------------------------------
        // setup your test
        //
        // we care about:
        // - message
        // - reason

        $value = 5;
        $reason = "see source code for details";
        $e = null;

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 14) . ': contract failed; ' . $reason;
        $expectedData = [
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 12),
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, __LINE__ + 11),
            'fieldOrVar' => $value,
            'fieldOrVarName' => 'value',
            'reason' => $reason,
            'dataType' => 'integer<' . $value . '>'
        ];

        // ----------------------------------------------------------------
        // perform the change

        try {
            AssertValue::apply($value < 4)->to($value);
        }
        catch (ContractFailed $e) {
            // do nothing
        }

        // ----------------------------------------------------------------
        // test the results

        // make sure we caught an exception
        $this->assertInstanceOf(ContractFailed::class, $e);

        // make sure it has the details we expect
        $actualMessage = $e->getMessage();
        $actualData = $e->getMessageData();

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testFailedAssertProvidesRejectedValue()
    {
        // ----------------------------------------------------------------
        // setup your test
        //
        // we care about:
        // - fieldOrVar
        // - dataType

        $value = 5;
        $reason = "must be less than 4";
        $e = null;

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 14) . ': contract failed; ' . $reason;
        $expectedData = [
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . '()@' . (__LINE__ + 12),
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, __LINE__ + 11),
            'fieldOrVar' => $value,
            'fieldOrVarName' => 'value',
            'reason' => $reason,
            'dataType' => 'integer<' . $value . '>'
        ];

        // ----------------------------------------------------------------
        // perform the change

        try {
            AssertValue::apply($value < 4, $reason)->to($value);
        }
        catch (ContractFailed $e) {
            // do nothing
        }

        // ----------------------------------------------------------------
        // test the results

        // make sure we caught an exception
        $this->assertInstanceOf(ContractFailed::class, $e);

        // make sure it has the details we expect
        $actualMessage = $e->getMessage();
        $actualData = $e->getMessageData();

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    public function provideFailedExpressions()
    {
        return [
            [ false ],
            [ 5 > 6 ],
        ];
    }
}
