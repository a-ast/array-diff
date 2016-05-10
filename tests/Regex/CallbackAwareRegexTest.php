<?php

namespace Aa\ArrayDiff\Tests\Regex;

use Aa\ArrayDiff\Regex\CallbackAwareRegex;
use PHPUnit_Framework_TestCase;

class CallbackAwareRegexTest extends PHPUnit_Framework_TestCase
{
    public function testCreateExpressionPatternWithoutParameters()
    {
        $pattern = new CallbackAwareRegex('hobbit', function() { return 'Bilbo'; });

        $this->assertEquals('hobbit', $pattern->getName());
        $this->assertEquals('Bilbo', $pattern->getPattern([]));
    }

    public function testCreateExpressionPatternWithParameters()
    {
        $callback = function($parameters) {
            return 'Bilbo '.$parameters[0].' '.$parameters[1];
        };

        $pattern = new CallbackAwareRegex('hobbit', $callback);

        $this->assertEquals('hobbit', $pattern->getName());
        $this->assertEquals('Bilbo Baggins Labingi', $pattern->getPattern(['Baggins', 'Labingi']));
    }
}
