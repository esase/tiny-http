<?php

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashevn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tiny\Http;

class RequestHttpParams implements RequestSystemParamsInterface
{

    const BASE_SCRIPT_NAME = '/index.php';

    /**
     * @var array
     */
    private $server;

    /**
     * RequestHttpParams constructor.
     *
     * @param  array  $server
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
        return $this->server['REQUEST_METHOD'] ?? '';
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '';
        // remove all trailing slashes
        $requestedUri = rtrim(parse_url($uri, PHP_URL_PATH), '/');

        // remove the base script name from the requested uri (we may work from a sub dir)
        $subDirectory = str_replace(
            self::BASE_SCRIPT_NAME,
            '',
            ($this->server['SCRIPT_NAME'] ?? '')
        );

        $request = strtolower(str_replace($subDirectory, '', $requestedUri));

        // at least a one single slash should be returned
        return $request ?: '/';
    }

}