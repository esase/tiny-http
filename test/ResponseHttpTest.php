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
use Tiny\Http\ResponseHttp;
use Tiny\Http\ResponseHttpUtils;

class ResponseHttpTest extends TestCase
{

    /**
     * @dataProvider responseProvider
     *
     * @param int    $code
     * @param mixed  $response
     * @param string $responseType
     * @param string $expectedResponse
     * @param array  $expectedHeaders
     */
    public function testGetResponseForDisplaying(
        int $code,
        $response,
        string $responseType,
        string $expectedResponse,
        array $expectedHeaders
    ) {
        $defaultHeader = 'default_header';
        $responseUtilsMock = $this->createMock(
            ResponseHttpUtils::class
        );

        $responseUtilsMock->expects($this->once())
            ->method('getDefaultHeaderByCode')
            ->with($code)
            ->willReturn($defaultHeader);

        $responseUtilsMock->expects($this->once())
            ->method('sendHeaders')
            ->with(
                array_merge(
                    [$defaultHeader],
                    $expectedHeaders
                )
            );

        $responseObject = new ResponseHttp($responseUtilsMock);
        $responseObject->setCode($code)
            ->setResponse($response)
            ->setResponseType($responseType);

        // initial response should be same
        $this->assertEquals(
            $response, $responseObject->getResponse()
        );

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
            [
                200,
                '{"name": "test"}',
                'application/json',
                '{"name": "test"}',
                ['Content-Type: application/json; charset=utf-8']
            ],
            [
                200,
                '<b>test</b>',
                'text/html',
                '<b>test</b>',
                ['Content-Type: text/html; charset=utf-8']
            ],
            [
                204,
                new class() {
                    public function __toString() {
                        return 'test';
                    }
                },
                'text/plain',
                'test',
                ['Content-Type: text/plain; charset=utf-8']
            ]
        ];
    }

}
