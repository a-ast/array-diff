# ArrayDiffCalculator

ArrayDiffCalculator works similar to a php function array_diff_assoc 
but calculates a difference of arrays in a better way due to:

* using expressions (value matching),
* providing extended information about an array difference.

Basic example:

```php
$array1 = ['a' => 1, 'b' => 2, 'c' => 3];
$array2 = ['a' => 7, 'b' => 2, 'd' => 3];

$calc = new ArrayDiffCalculator(new SimpleMatcher());
print $calc->calculateDiff($array1, $array2)->toString();
```

will output:

```
missing:
    'c' => 3
unmatched:
    'a' => 1
```


Advanced example. All items of Array #2 match values of Array #1:

<table>
<tr><td>Array #1</td><td>Array #2</td></tr>
<tr>
<td>
<pre lang="php">
$array1 = [
    'name'     => '&lt;type.string&gt;',
    'price'    => '&lt;type.float(2)&gt;',
    'price_f'  => '&lt;type.float(2)&gt;',
    'in_stock' => true,
    'isbns'    => [
        'isbn-10' => '',
        'isbn-13' => '',
    ],
    'url'      => '<type.link>'
];
</pre>
</td>
<td>
<pre lang="php">
$array2 = [
    'name'    => 'The Lord of the Rings',
    'price'   => '25,99',
    'price_f' => '25,99 EUR',
    'in_stock' => true,
    'isbns'    => [
        'isbn-10' => '',
        'isbn-13' => '',
    ],
    'url'      => 'http://book.book/LOTR'
];
</pre> 
</td>
</tr>
</table>

```php

$calc = new ArrayDiffCalculator(new ExpressionMatcher());
$diff = $calc->calculateDiff($array1, $array2)->toArray();
```
