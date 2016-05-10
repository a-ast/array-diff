# ArrayDiff Calculator

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00de23df-b87f-4bab-9322-f794cad333fc/mini.png)](https://insight.sensiolabs.com/projects/00de23df-b87f-4bab-9322-f794cad333fc)

ArrayDiff Calculator works similar to a php function ```array_diff_assoc``` 
but calculates a difference of arrays in a better way due to:

* using expressions (value matching),
* providing extended information about an array difference.

**Example**

```php
$array1 = ['a' => 8, 'b' => 2, 'c' => 3];
$array2 = ['a' => 6, 'b' => 2, 'd' => 3];

$calc = new Calculator(new SimpleMatcher());
$diff = $calc->calculateDiff($array1, $array2);

print $diff->toString();
```

outputs:

```yaml
missing:
    -
        key_path: c
        expected: 3
unmatched:
    -
        key_path: a
        expected: 8
        actual: 6
```

because

* Item with the key 'c' is **missing** in array2
* Items with key 'a' have different values (**unmatched**)

**Advanced example**

Let's assume we have two arrays:

<table>
<tr>
<td width="50%">
<pre lang="php">
$array1 = [
    'name'     => '<type.string>',
    'price'    => '<type.float(2)> <type.string>',
    'in_stock' => '<type.boolean>',
    'isbns'    => [
        'isbn-10' => '<type.string>',
    ],
    'pages'    => '<type.datetime>',
];
</pre>
</td>
<td width="50%">
<pre lang="php">
$array2 = [
    'name'     => 'The Lord of the Rings',
    'price'    => '25.99 EUR',
    'in_stock' => true,
    'isbns'    => [
        'isbn-10' => '1230260002385',
    ],
    'pages'    => 567,
];
</pre> 
</td>
</tr>
</table>

You can calculate a difference of these arrays using an expression matching:
```php
$calc = new Calculator(new ExpressionMatcher());
$diff = $calc->calculateDiff($array1, $array2);

print $diff->toString();
```

It returns:
```yaml
missing: {  }
unmatched:
    -
        key_path: pages
        expected: '<type.datetime>'
        actual: 567
```

because

* keys of array1 match keys of array2, so there are no missing items
* string 'The Lord of the Rings' matches the expression ```<type.string>```
* '25.99 EUR' matches the compound expression ```<type.float(2)> <type.string>```
* 'true' matches the expression ```<type.boolean>```
* isbn value '1230260002385' matches the expression ```<type.string>```
* page count '567' **doesn't match** the expression ```<type.datetime>```

Expressions have syntax ```<expresion-name(param1, param2,...)>```.
