<?php

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashevn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TinyTest\Http;

use PHPUnit\Framework\TestCase;
use Tiny\Http\Exception\InvalidArgumentException;
use Tiny\Http\ResponseHttpUtils;

class ResponseHttpUtilsTest extends TestCase
{

    public function testGetDefaultHeaderByCodeMethod()
    {
        $utils = new ResponseHttpUtils();

        $this->assertEquals(
            'HTTP/1.1 200 OK', $utils->getDefaultHeaderByCode(200)
        );
    }

    public function testGetDefaultHeaderByCodeMethodUsingNotRegisteredCode()
    {
        $code = 1000;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Header is not registered for the code "%d"',
                $code
            )
        );
        $utils = new ResponseHttpUtils();
        $utils->getDefaultHeaderByCode($code);
    }

}
