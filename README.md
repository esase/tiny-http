# tiny-http

[![Build Status](https://travis-ci.com/esase/tiny-http.svg?branch=master)](https://travis-ci.com/github/esase/tiny-http/builds)
[![Coverage Status](https://coveralls.io/repos/github/esase/tiny-http/badge.svg?branch=master)](https://coveralls.io/github/esase/tiny-http?branch=master)

An abstraction layer for http and console requests and responses, may be used for internal communication in your application

## Installation

Run the following to install this library:

```bash
$ composer require esase/tiny-http
```

## Request

The Request object is responsible for managing the input state both in the `HTTP` and `CLI` modes. 
It provides an abstraction layer for getting input data like: a current request and the request's method. 

**Let consider an example for the `HTTP` mode:**

```php
<?php 

  use Tiny\Http\Request;
  use Tiny\Http\RequestHttpParams;

  $request = new Request(
      new RequestHttpParams($_SERVER)
  );

  echo $request->getRequest(); // prints the current request like: "/", "/users", "/documents/view", etc
  echo $request->getMethod(); // prints the current method like: "GET", "POST", "DELETE", etc
```

PS: The `RequestHttpParams` ignores any http `GET` parameters and returns only the request's path. 
E.g `/users/?param=1` would be `/users`, also it removes sub directory path - `sub_directory/users/` would be `/users`, it very
helpful for the routing handling.

**Let consider an example for the `CLI` mode:**


```php
<?php 

  use Tiny\Http\Request;
  use Tiny\Http\RequestCliParams;

  $request = new Request(
      new RequestCliParams($_SERVER)
  );

  echo $request->getRequest(); // prints the current request like: "users", "user import 1", etc
  echo $request->getMethod(); // prints the current method like: "CONSOLE"
  
  // example of calling: php index.php user import 1
```

**We even can create a universal way for handling the request, and don't care if it `CLI` or `HTTP` mode**

```php
<?php 

use Tiny\Http\Request;
use Tiny\Http\RequestCliParams;
use Tiny\Http\RequestHttpParams;

$request = new Request((php_sapi_name() === 'cli' 
    ? new RequestCliParams($_SERVER) 
    : new RequestHttpParams($_SERVER)
));
```
