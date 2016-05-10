<?php

namespace Aa\ArrayDiff\Tests\Regex;

use Aa\ArrayDiff\Regex\RegexRegex;
use PHPUnit_Framework_TestCase;

class RegexRegexTest extends PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $regex = new RegexRegex();
        $this->assertEquals('regex.regex', $regex->getName());
    }

    public function testGetPattern()
    {
        $regex = new RegexRegex();
        $this->assertEquals('(.*)', $regex->getPattern(['(.*)']));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetPatternFailsWithInvalidParameters()
    {
        $regex = new RegexRegex();
        $regex->getPattern([]);
    }
}
