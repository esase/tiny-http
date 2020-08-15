<?php

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TinyTest\Http;

use PHPUnit\Framework\TestCase;
use Tiny\Http\ResponseCli;

class ResponseCliTest extends TestCase
{

    /**
     * @dataProvider responseProvider
     *
     * @param $response
     * @param $expectedResponse
     */
    public function testGetResponseForDisplaying(
        $response,
        $expectedResponse
    ) {
        $responseObject = new ResponseCli();
        $responseObject->setResponse($response);

        $this->assertEquals(
            $expectedResponse, $responseObject->getResponseForDisplaying()
        );
    }

    /**
     * @return array
     */
    public function responseProvider(): array
    {
        return [
            ['test', 'test'],
            [10, 10],
            [true, true],
            [new class() {
                public function __toString() {
                    return 'Test';
                }
            }, 'Test'],
        ];
    }

}
