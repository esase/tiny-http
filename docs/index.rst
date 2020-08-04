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

    $request = new Request((php_sapi_name() === 'cli'
        ? new RequestCliParams($_SERVER)
        : new RequestHttpParams($_SERVER)
    ));
