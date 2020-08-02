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
use Tiny\Http\RequestHttpParams;

class RequestHttpParamsTest extends TestCase
{

    public function testGetRequest()
    {
        $instance = new RequestHttpParams(
            [
                'REQUEST_URI' => '/test/test?param=test',
            ]
        );
        $this->assertEquals('/test/test', $instance->getRequest());
    }

    public function testGetRequestUsingSubDir()
    {
        $instance = new RequestHttpParams(
            [
                'REQUEST_URI' => 'sub_dir1/sub_dir2/test/test?param=test',
                'SCRIPT_NAME' => 'sub_dir1/sub_dir2/index.php',
            ]
        );
        $this->assertEquals('/test/test', $instance->getRequest());
    }

    public function testGetRequestUsingTrailingSlash()
    {
        $instance = new RequestHttpParams(
            [
                'REQUEST_URI' => '/test/test/?param=test',
            ]
        );
        $this->assertEquals('/test/test', $instance->getRequest());
    }

    public function testGetRequestUsingSingleSlash()
    {
        $instance = new RequestHttpParams(
            [
                'REQUEST_URI' => '/',
            ]
        );
        $this->assertEquals('/', $instance->getRequest());
    }

    public function testGetRequestUsingMultipleSlashes()
    {
        $instance = new RequestHttpParams(
            [
                'REQUEST_URI' => '//////////////',
            ]
        );
        $this->assertEquals('/', $instance->getRequest());
    }

    public function testGetMethod()
    {
        $method = 'GET';
        $instance = new RequestHttpParams(
            [
                'REQUEST_METHOD' => $method,
            ]
        );
        $this->assertEquals($method, $instance->getMethod());
    }

}
