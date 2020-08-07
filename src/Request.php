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

class Request
{

    const METHOD_CONSOLE = 'CONSOLE';

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

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
     * @param  RequestSystemParamsInterface  $requestSystemParams
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
     * @return string
     */
    public function getRequest(): string
    {
        return $this->requestSystemParams->getRequest();
    }

    /**
     * @param  array  $params
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
     * @param  string  $name
     * @param  mixed   $defaultValue
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