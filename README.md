# tiny-http

[![Build Status](https://travis-ci.com/esase/tiny-http.svg?branch=master)](https://travis-ci.com/github/esase/tiny-http/builds)
[![Coverage Status](https://coveralls.io/repos/github/esase/tiny-http/badge.svg?branch=master)](https://coveralls.io/github/esase/tiny-http?branch=master)


Basically each web application starts with an `INPUT` (an incoming request which would be: `GET`, `POST`, etc) 
and an `OUTPUT` a final response (`JSON`, `HTML`, `XML`, etc).

So the **Tiny/Http** it's an layer which holds both `INPUT` and `OUTPUT` objects and gives to
your application a possibility to manipulate with them during the application's lifecycle.

Due to the simple interface of the package it can be integrated to any web application.

## Request object

The request would be either an `http` query (a query received from a `web server`) 
or received from a command line interface ([CLI](https://en.wikipedia.org/wiki/Command-line_interface))

e.g:

`[POST] http://test.com/import/files`
`[CLI] php import files`

```php

<?php

    use Tiny\Http\Request;
    use Tiny\Http\RequestCliParams;
    use Tiny\Http\RequestHttpParams;

    $request = new Request((php_sapi_name() === 'cli'
        ? new RequestCliParams($_SERVER)
        : new RequestHttpParams($_SERVER)
    ));

    echo $request->getRequest(); // prints the `files/import` or `import files` for the CLI mode
    echo $request->getMethod(); // prints `GET`, `POST`, `CONSOLE`, etc

```

In code snippet above the `Request` object extracts a requests method and a request string from a super global array of [$_SERVER](https://www.php.net/manual/en/reserved.variables.server.php).
You should not be worried which mode is activated now `CLI` or the `Http` both follow to a one interface. 

## Response object

The `Response` object mostly used to generate a final result which will be returned back to a `web server` or `command line` and
it usually keeps `response code`, `response type` and the `response` it self.
The response object could be modified by controllers (if we are following  by [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) structure or somewhere else like [Middleware](https://en.wikipedia.org/wiki/Middleware)

```php

<?php

    use Tiny\Http\ResponseCli;
    use Tiny\Http\ResponseHttp;
    use Tiny\Http\ResponseHttpUtils;

    $response = (php_sapi_name() === 'cli'
        ? new ResponseCli()
        : new ResponseHttp(
            new ResponseHttpUtils()
        );

    $response
        ->setCode(201)
        ->setResponse('{"name": "test"}')
        ->setResponseType('application/json');

    // we don't care about neither "CLI" nor "HTTP", we just print the value
    echo $response->getResponseForDisplaying();
```

Under the hood the `Response` object uses `headers` (for the `http` mode ) which will be sending depending on your response type read more in the documentation.

## Installation

Run the following to install this library:

```bash
$ composer require esase/tiny-http
```

## Documentation

https://tiny-docs.readthedocs.io/en/latest/tiny-http/docs/index.html
