<?php

namespace Aa\ArrayDiff\Tests\Matcher;

use Aa\ArrayDiff\Matcher\ExpressionMatcher;
use Aa\ArrayDiff\Tests\YamlFixtureAwareTrait;
use PHPUnit_Framework_TestCase;

class ExpressionMatcherTest extends PHPUnit_Framework_TestCase
{
    use YamlFixtureAwareTrait;
    /**
     * @dataProvider dataProvider
     */
    public function testIsMatched($pattern, $value, $isMatched)
    {
        $matcher = new ExpressionMatcher();
        
        $this->assertEquals($isMatched, $matcher->isMatched($pattern, $value));
    }

    public function dataProvider()
    {
        return  $this->getDataFromFixtureFile('fixtures', 'Matcher');
    }
}
