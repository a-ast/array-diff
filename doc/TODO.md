# TODO

Dev

* Implement parameters for Existing regexes
* * take system decimal point for float regex
* Extract Diff formater
* Implement DiffInterface methods

Tests
* Write MORE tests for expression matcher array comparison
* Write more tests, check coverage

Infrastructure
* Configure Scrutinizer or SLI to run all tests

Writing
* Write README
* Write blog post about array comparisons


For article:

<?php
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");
$result = array_diff_assoc($array1, $array2);
print_r($result);
?>

gives

Array
(
    [b] => brown
    [c] => blue
    [0] => red
)

However, 'red' is in both! My solution covers it. Test.
