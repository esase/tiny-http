<?php

namespace Tiny\Http;

/*
 * This file is part of the Tiny package.
 *
 * (c) Alex Ermashev <alexermashevn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ResponseHttp extends AbstractResponse
{

    /**
     * @var ResponseHttpUtils
     */
    private ResponseHttpUtils $utils;

    /**
     * HttpResponse constructor.
     *
     * @param ResponseHttpUtils $utils
     */
    public function __construct(ResponseHttpUtils $utils)
    {
        $this->utils = $utils;
    }

    /**
     * @return mixed
     */
    public function getResponseForDisplaying()
    {
        // prepare list of headers
        $headers = [
            $this->utils->getDefaultHeaderByCode($this->code)
        ];

        // add additional headers based on the type
        switch ($this->responseType) {
            case AbstractResponse::RESPONSE_TYPE_TEXT :
                $headers[] = 'Content-Type: text/plain; charset=utf-8';
                break;

            case AbstractResponse::RESPONSE_TYPE_JSON :
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                break;

            case AbstractResponse::RESPONSE_TYPE_HTML :
            default:
                $headers[] = 'Content-Type: text/html; charset=utf-8';
                break;
        }

        // send headers
        $this->utils->sendHeaders($headers);

        return parent::getResponseForDisplaying();
    }

}
