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

interface RequestSystemParamsInterface
{

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getRequest(): string;

}