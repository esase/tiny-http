<?php

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tiny\Http;

class RequestCliParams implements RequestSystemParamsInterface
{

    /**
     * @var array
     */
    private array $server;

    /**
     * RequestCliParams constructor.
     *
     * @param array $server
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return Request::METHOD_CONSOLE;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        $request = '';
        $arguments = $this->server['argv'] ?? [];

        if ($arguments) {
            // the first element "index.php" should be skipped
            array_shift($arguments);

            // collect the rest of elements
            $request = implode(' ', $arguments);
        }

        return $request;
    }

    /**
     * @return mixed
     */
    public function getRawRequest()
    {
        return $arguments = $this->server['argv'] ?? [];
    }

}
