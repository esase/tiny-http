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
use Tiny\Http\RequestCliParams;

class RequestCliParamsTest extends TestCase
{

    public function testGetRequest()
    {
        $instance = new RequestCliParams(
            [
                'argv' => [
                    'index.php',
                    'test',
                    '10',
                    '--force',
                ],
            ]
        );
        $this->assertEquals('test 10 --force', $instance->getRequest());
    }

    public function testGetMethod()
    {
        $instance = new RequestCliParams([]);
        $this->assertEquals('CONSOLE', $instance->getMethod());
    }

}
