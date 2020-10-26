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

class Request
{

    const METHOD_CONSOLE = 'CONSOLE';

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @var RequestSystemParamsInterface
     */
    private RequestSystemParamsInterface $requestSystemParams;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * Request constructor.
     *
     * @param RequestSystemParamsInterface $requestSystemParams
     */
    public function __construct(
        RequestSystemParamsInterface $requestSystemParams
    ) {
        $this->requestSystemParams = $requestSystemParams;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->requestSystemParams->getMethod();
    }

    /**
     * @return bool
     */
    public function isConsole(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_CONSOLE;
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_GET;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_POST;
    }

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_PUT;
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_DELETE;
    }

    /**
     * @return bool
     */
    public function isOptions(): bool
    {
        return $this->requestSystemParams->getMethod() === self::METHOD_OPTIONS;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->requestSystemParams->getRequest();
    }

    /**
     * @return mixed
     */
    public function getRawRequest($isJson = true)
    {
        $rawRequest = $this->requestSystemParams->getRawRequest();

        return $isJson && is_string($rawRequest)
            ? json_decode($rawRequest, true)
            : $rawRequest;
    }
 
    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    public function getParam(string $name, $defaultValue = null)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        if (null !== $defaultValue) {
            return $defaultValue;
        }

        throw new Exception\InvalidArgumentException(
            sprintf(
                'Request param "%s" not found',
                $name
            )
        );
    }

}
