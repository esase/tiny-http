<?php

namespace Tiny\Http;

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ResponseHttpUtils
{

    /**
     * @var array
     */
    private array $defaultHeaders
        = [
            AbstractResponse::RESPONSE_OK             => 'HTTP/1.1 200 OK',
            AbstractResponse::RESPONSE_CREATED        => 'HTTP/1.1 201 OK',
            AbstractResponse::RESPONSE_NO_CONTENT     => 'HTTP/1.1 204 OK',
            AbstractResponse::RESPONSE_NOT_FOUND      => 'HTTP/1.1 404 Not Found',
            AbstractResponse::RESPONSE_BAD_REQUEST    => 'HTTP/1.1 400 Bad Request',
            AbstractResponse::RESPONSE_CONFLICT       => 'HTTP/1.1 409 Conflict',
            AbstractResponse::RESPONSE_INTERNAL_ERROR => "HTTP/1.1 500 Internal Server Error",
        ];

    /**
     * @param int $code
     *
     * @return string
     */
    public function getDefaultHeaderByCode(int $code): string
    {
        if (isset($this->defaultHeaders[$code])) {
            return $this->defaultHeaders[$code];
        }

        throw new Exception\InvalidArgumentException(
            sprintf(
                'Header is not registered for the code "%d"',
                $code
            )
        );
    }

    /**
     * @param array $headers
     */
    public function sendHeaders(array $headers)
    {
        foreach ($headers as $header) {
            header($header);
        }
    }

}
