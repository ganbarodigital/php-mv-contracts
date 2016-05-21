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

use GanbaroDigital\Contracts\V1\Contracts\ContractChecks;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\Contracts\V1\Contracts\ContractChecks
 */
class ContractChecksTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::areEnabled
     */
    public function testContractChecksAreEnabledByDefault()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(ContractChecks::areEnabled());
    }

    /**
     * @covers ::enable
     */
    public function testCanEnableContractChecks()
    {
        // ----------------------------------------------------------------
        // setup your test

        // make sure that wrapped contracts are off
        ContractChecks::disable();
        $this->assertFalse(ContractChecks::areEnabled());

        // ----------------------------------------------------------------
        // perform the change

        ContractChecks::enable();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(ContractChecks::areEnabled());
    }

    /**
     * @covers ::disable
     */
    public function testCanDisableContractChecks()
    {
        // ----------------------------------------------------------------
        // setup your test

        // make sure that wrapped contracts are on
        ContractChecks::enable();
        $this->assertTrue(ContractChecks::areEnabled());

        // ----------------------------------------------------------------
        // perform the change

        ContractChecks::disable();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(ContractChecks::areEnabled());
    }

    /**
     * @covers ::areEnabled
     */
    public function testCanCheckIfContractChecksAreEnabled()
    {
        // ----------------------------------------------------------------
        // setup your test

        ContractChecks::disable();
        $this->assertFalse(ContractChecks::areEnabled());

        // ----------------------------------------------------------------
        // perform the change

        ContractChecks::enable();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(ContractChecks::areEnabled());
    }
}
