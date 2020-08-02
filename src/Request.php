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
     * @var array
     */
    public $allowedMethods
        = [
            self::METHOD_CONSOLE,
            self::METHOD_POST,
            self::METHOD_GET,
            self::METHOD_PUT,
            self::METHOD_DELETE,
        ];

    /**
     * @var RequestSystemParamsInterface
     */
    private $requestSystemParams;

    /**
     * @var array
     */
    private $params = [];

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