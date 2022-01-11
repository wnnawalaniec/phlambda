# phlambda
[![Build Status](https://travis-ci.com/wnnawalaniec/phlambda.svg?branch=master)](https://travis-ci.com/wnnawalaniec/phlambda)
[![Version](http://poser.pugx.org/wojciech.nawalaniec/phlambda/version)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)
[![Coverage Status](https://coveralls.io/repos/github/wnnawalaniec/phlambda/badge.svg?branch=master)](https://coveralls.io/github/wnnawalaniec/phlambda?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fwnnawalaniec%2Fphlambda%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/wnnawalaniec/phlambda/master)
[![Latest Stable Version](http://poser.pugx.org/wojciech.nawalaniec/phlambda/v)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)
[![Latest Unstable Version](http://poser.pugx.org/wojciech.nawalaniec/phlambda/v/unstable)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)
[![Total Downloads](http://poser.pugx.org/wojciech.nawalaniec/phlambda/downloads)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)
[![License](http://poser.pugx.org/wojciech.nawalaniec/phlambda/license)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)
[![PHP Version Require](http://poser.pugx.org/wojciech.nawalaniec/phlambda/require/php)](https://packagist.org/packages/wojciech.nawalaniec/phlambda)

Functional library for PHP.

Features:
 - set of useful functions helpful in functional programming
 - all functions are automatically curried
 - every array can be wrapped with special class which allows for method chaining
 - first param is always function and the data to be operated will be last param
 
## Table of contents:
- [Installation](#basics)
- [Usage](#basics)
- [Docs](#docs)
- [Currying](#currying)
- [Backstory](#backstory)
- [TODO](#todo)
 
## Installation
To install run:
```
composer require wojciech.nawalaniec/phlambda
```

## Usage
All functions and constants are in one namespace, so it won't create any conflict with existing ones in your project
or other libraries.
You can simply import namespaces with alias (for simplification), like this:
```php
use Wojciech\Phlambda as f;

f\all(f\above(2), [1, 2, 3, 4]);
```

You can import one or few functions using import like this:
```php
use function Wojciech\Phlambda\{all, above};

all(above(2), [1, 2, 3, 4]);
```

There are also constants which can be used in places accepting callbacks, because PHP
will resolve them as functions:
```php
use function Wojciech\Phlambda\map;
use const Wojciech\Phlambda\toString;

map(toString, [1, 2, 3]);
```

If you have some array and wish to perform multiple, chained operations on it. You can wrapp it
with special object with `_()` function:

```php
use function Wojciech\Phlambda\{_, below, concat};
use const Wojciech\Phlambda\toString;

_($someArray)
    ->all(below(30))
    ->map(toString) // you can use constant which will be resolved as callable by PHP
    ->reduce(concat(), ''); // or you can call function without params because all functions all curried
```

If you wish to have more readable code you can use a static method from that class instead: `Wrapper::wrap($array)`.

If you don't want to use objects you can use just functions. Wrapper's methods are just delegates to those functions,
and exists only for chaining purposes.

## Docs

[Here you can find documentation.](https://wnnawalaniec.github.io/phlambda/packages/Application.html)

## Currying
In this library all function are automatically curried. If you don't know what curry functions let me try to change it.
According to [Wikipedia](https://en.wikipedia.org/wiki/Currying):
> In mathematics and computer science, currying is the technique of converting a function that takes multiple arguments into a sequence of functions that each takes a single argument.

Let's see an example:
 ```php
// we can use reduce function normally like this:
$array = ['a', 'b', 'c'];
$result = reduce(\Wojciech\Phlambda\concat, '', $array); // $result = 'abc'

// and we can use it like cirrying function:
$concat = reduce(\Wojciech\Phlambda\concat, ''); // now it will return callback accepting last param from reduce - an array
$result = $concat($array); // $result = 'abc'
```

## Backstory
PHP was not designed as functional programming language, that's one thing I'm sure. 
We can create and use anonymous functions, and in `7.4` we even got arrow functions `fn () =>`.
Language itself is providing us with some functions like `array_map()` etc. where we can pass an array
and some callable to perform some operations on the input.
But its... so cumbersome.

One day at the company my friend joked about PHP and said that it's sad we can't do something like this in PHP:
```js
someArray.every(below(30));
```

I thought for a while, and respond with something like this:
```php
function below(int $val): callable
{
    return fn(int $v) => $v < $val;
}

function every(array $a, callable $fn): array
{
    return array_filter($a, $fn);
}

$arr = [1, 2, 3, 4];
every($arr, below(3));
```

Both examples are similar, but we can see that with PHP solution we have no way of chaining methods together, also we
must write most of that method our selves. After while another idea came up to my mind. We could leverage OOP and create
class which implements `\ArrayAccess` so it can be considered array like, and have all that nice methods we can chain together.
I thought about something like this:
```php
$arrayObject
    ->every(below(30))
    ->sum();
```
It seemed as a great weekend project so here it is.

There are some great functional libraries for JS, but one (pointed by earlier mentioned friend) seemed interesting.
It's [Ramda](https://github.com/ramda/ramda). It's interesting because it has all function automatically curried, and it
adds some complexity to that project.

## TODO
- implement more methods
- add placeholders for curry functions - it seems as interesting thing to do
