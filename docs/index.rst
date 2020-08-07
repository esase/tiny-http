.. _index-http-label:

HTTP
====

An abstraction layer for http and console requests and responses, may be used for internal communication in your application.

Installation
------------

Run the following to install this library:


.. code-block:: bash

    $ composer require esase/tiny-http

Request
-------

The :code:`Request` object is responsible for managing the input state both in the `HTTP` and `CLI` modes.
It provides an abstraction layer for getting input data like: a current request and the request's method.

------------
HTTP example
------------

.. code-block:: php

    <?php

        use Tiny\Http\Request;
        use Tiny\Http\RequestHttpParams;

        $request = new Request(
          new RequestHttpParams($_SERVER)
        );

        echo $request->getRequest(); // prints the current request like: "/", "/users", "/documents/view", etc
        echo $request->getMethod(); // prints the current method like: "GET", "POST", "DELETE", etc

PS: The :code:`RequestHttpParams` ignores any http `GET` parameters and returns only the request's path.
E.g :code:`/users/?param=1` would be :code:`/users`, also it removes sub directory path - :code:`sub_directory/users/` would be just :code:`/users`, it very
helpful for the routing handling.

-----------
CLI example
-----------

.. code-block:: php

    <?php

        use Tiny\Http\Request;
        use Tiny\Http\RequestCliParams;

        $request = new Request(
          new RequestCliParams($_SERVER)
        );

        echo $request->getRequest(); // prints the current request like: "users", "user import 1", etc
        echo $request->getMethod(); // prints the current method like: "CONSOLE"

        // example of calling: php index.php user import 1

-----------------
Universal example
-----------------

In this case we don't really care about the current mode, we just work with the abstraction.

.. code-block:: php

    <?php

        use Tiny\Http\Request;
        use Tiny\Http\RequestCliParams;
        use Tiny\Http\RequestHttpParams;

        // a good tip: the should be placed in a factory
        $request = new Request((php_sapi_name() === 'cli'
            ? new RequestCliParams($_SERVER)
            : new RequestHttpParams($_SERVER)
        ));

        echo $request->getRequest();
        echo $request->getMethod();

Response
--------

The :code:`Response` object holds and returns a server’s answer to your clients.
The response maybe changed in any time in any place in you application.
So it's good choice if you are going to use **Middlewares** and it also works good using in old **MVC paradigm**.

------------
HTTP example
------------

.. code-block:: php

    <?php

        use Tiny\Http\ResponseHttp;
        use Tiny\Http\ResponseHttpUtils;

        $response = new ResponseHttp(
            new ResponseHttpUtils()
        );

        $response
            ->setCode(200)
            ->setResponse('Hello world')
            ->setResponseType('text/html');

        // prints "Hello world" and send associated headers
        echo $response->getResponseForDisplaying();

Take into account you don't need to run manually the :code:`header()` function. Because it triggers automatically
based on the provided response `code` and `type` whenever you call the :code:`getResponseForDisplaying()` method. In our case these headers are sent:

- HTTP/1.1 200 OK
- Content-Type: text/html; charset=utf-8

-----------
CLI example
-----------

.. code-block:: php

    <?php

        use Tiny\Http\ResponseCli;

        $response = new ResponseCli();

        // we even can pass an object as a response, which will be transformed in a string
        $response->setResponse(new class() {
            public function __toString() {
                return 'Hello world';
            }
        });

        // prints "Hello world"
        echo $response->getResponseForDisplaying();

In comparison with the `HTTP` analog it doesn't send any headers, it only returns the request. Also you can skipp
the adding both "code" and "type" they are not used in the `CLI` mode.

-----------------
Universal example
-----------------

If we don't need to know about the current context we can build an abstraction layer.

.. code-block:: php

    <?php

        use Tiny\Http\ResponseCli;
        use Tiny\Http\ResponseHttp;
        use Tiny\Http\ResponseHttpUtils;

        // a good tip: the should be placed in a factory
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