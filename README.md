# phlambda
Where you ever been envy of those neet looking JS constructions like:
```js
someArray
  .all(below(30))
  .map(someMapFn)
  .reduce(someReduceFn);
```

Of course you can do something similar in PHP:
```php
array_reduce(
    array_map(
        array_filter($someArray, fn($a) => $a < 30),
        'someMapFn'
    ),
    'someReduceFn'
)
```

Sure it works similar, but is not even closely as readable as JS example.
It looks just... weird.
But what about that:
```php
reduce(
    map(
        all($someArray, below(30)),
        'someMapFn'
    ),
    'someReduceFn'
)
```

It's still not great because with every next operation new indentation comes in.
Ofcourse you can write it in single line, or split it to multiple statements but it's not that nice anymore or readability gets hurt.
Can we do better with PHP? I think we can:
```php
arr($someArray)
    ->all(below(30))
    ->map('someMapFn')
    ->reduce('someReduceFn');
```
