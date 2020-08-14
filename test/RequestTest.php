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
use Tiny\Http\Request;
use Tiny\Http\RequestSystemParamsInterface;

class RequestTest extends TestCase
{

    public function testIsConsoleMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('CONSOLE');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isConsole());
    }

    public function testIsGetMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isGet());
    }

    public function testIsPostMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isPost());
    }

    public function testIsPutMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('PUT');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isPut());
    }

    public function testIsDeleteMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('DELETE');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isDelete());
    }

    public function testIsOptionsMethod()
    {
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn('OPTIONS');

        $request = new Request($systemParamsMock);

        $this->assertTrue($request->isOptions());
    }

    public function testGetMethod()
    {
        $method = 'GET';
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getMethod')
            ->willReturn($method);

        $request = new Request($systemParamsMock);

        $this->assertEquals($method, $request->getMethod());
    }

    public function testGetRequestMethod()
    {
        $requestString = '/test';
        $systemParamsMock = $this->createMock(
            RequestSystemParamsInterface::class
        );
        $systemParamsMock->expects($this->once())
            ->method('getRequest')
            ->willReturn($requestString);

        $request = new Request($systemParamsMock);

        $this->assertEquals($requestString, $request->getRequest());
    }

    public function testGetParamMethod()
    {
        $id = 'test';
        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );

        $request = new Request($systemParamsStub);
        $request->setParams(
            [
                'id' => $id,
            ]
        );
        $this->assertEquals($id, $request->getParam('id'));
        $this->assertEquals(1, count($request->getParams()));
    }

    public function testGetParamMethodUsingDefaultValues()
    {
        $id = 'test';
        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );

        $request = new Request($systemParamsStub);
        $request->setParams([]);
        $this->assertEquals($id, $request->getParam('id', $id));
    }

    public function testGetParamMethodUsingNotRegisteredParams()
    {
        $param = 'id';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Request param "%s" not found',
                $param
            )
        );

        $systemParamsStub = $this->createStub(
            RequestSystemParamsInterface::class
        );
        $request = new Request($systemParamsStub);
        $request->setParams([]);
        $request->getParam($param);
    }

}
