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

class AbstractResponse
{

    const RESPONSE_OK = 200;
    const RESPONSE_CREATED = 201;
    const RESPONSE_NO_CONTENT = 204;
    const RESPONSE_BAD_REQUEST = 400;
    const RESPONSE_UNAUTHORIZED = 401;
    const RESPONSE_NOT_FOUND = 404;
    const RESPONSE_NOT_ALLOWED = 405;
    const RESPONSE_CONFLICT = 409;
    const RESPONSE_INTERNAL_ERROR = 500;

    const RESPONSE_TYPE_TEXT = 'text/plain';
    const RESPONSE_TYPE_HTML = 'text/html';
    const RESPONSE_TYPE_JSON = 'application/json'; 

    /**
     * @var int
     */
    protected int $code = self::RESPONSE_OK;

    /**
     * @var string
     */
    protected string $responseType = self::RESPONSE_TYPE_HTML;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param string $responseType
     *
     * @return $this
     */
    public function setResponseType(string $responseType)
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * @param mixed $response
     *
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getResponseForDisplaying()
    {
        return is_object($this->response) ? $this->response->__toString()
            : $this->response;
    }

}
