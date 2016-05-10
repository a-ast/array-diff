<?php

namespace Aa\ArrayDiff\Tests;

use Aa\ArrayDiff\ArrayDiffCalculator;
use Aa\ArrayDiff\Diff\ArrayDiffInterface;
use Aa\ArrayDiff\Diff\DiffFormats;
use Aa\ArrayDiff\Matcher\ExpressionMatcher;
use Aa\ArrayDiff\Matcher\SimpleMatcher;
use PHPUnit_Framework_TestCase;

class ArrayDiffCalculatorTest extends PHPUnit_Framework_TestCase
{
    use YamlFixtureAwareTrait;

    /**
     * @dataProvider fixtureSimpleDataProvider
     */
    public function testDiffWithSimpleMatcher($expected, $actual, $expectedDiff)
    {
        $calculator = new ArrayDiffCalculator(new SimpleMatcher());
        $calculator->setSequentialKeysSupported(true);
        
        $actualDiff = $calculator->calculateDiff($expected, $actual)->toArray(DiffFormats::FULL);
        
        $this->assertEquals($expectedDiff, $actualDiff);
    }

    /**
     * @dataProvider fixtureSimpleDataProvider
     */
    public function testThatSimpleMatcherDiffIsEqualToStandardArrayDiff($expected, $actual, $expectedDiff)
    {
        $calculator = new ArrayDiffCalculator(new SimpleMatcher());
        $calculator->setSequentialKeysSupported(true);
        
        $standardDiff = array_diff_recursive($expected, $actual);
        $formattedAsStandardDiff = $actualDiff = $calculator->calculateDiff($expected, $actual)->toArray(DiffFormats::PHP_FUNCTION_ALIKE);

        $this->assertEquals($standardDiff, $formattedAsStandardDiff);
    }

    /**
     * @dataProvider fixtureExpressionDataProvider
     */
    public function testDiffWithExpressionMatcher($expected, $actual, $expectedDiff)
    {
        $calculator = new ArrayDiffCalculator(new ExpressionMatcher());

        $actualDiff = $calculator->calculateDiff($expected, $actual)->toArray(DiffFormats::FULL);

        $this->assertEquals($expectedDiff, $actualDiff);
    }   
    
    public function fixtureSimpleDataProvider()
    {
        return $this->getDataFromFixtureFile('simple');
    }

    public function fixtureExpressionDataProvider()
    {
        return $this->getDataFromFixtureFile('expression');
    }
}

function array_diff_recursive(&$array1, &$array2)
{
    $diff = [];

    foreach ($array1 as $key => $value)
    {
        if (array_key_exists($key, $array2)) {
            
            if (is_array($value)) {
                
                $recursiveDiff = array_diff_recursive($value, $array2[$key]);

                if (count($recursiveDiff)) {
                    $diff[$key] = $recursiveDiff;
                }
            } elseif (!in_array($value, $array2)) {
                $diff[$key] = $value;
            }
        } elseif (!in_array($value, $array2)) {
            $diff[$key] = $value;
        }
    }

    return $diff;
}
