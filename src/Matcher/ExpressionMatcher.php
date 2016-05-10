<?php

namespace Aa\ArrayDiff\Matcher;

use Aa\ArrayDiff\Regex\RegexCollection;
use Aa\ArrayDiff\Regex\RegexRegex;
use Aa\ArrayDiff\Regex\TypeRegexCollection;

class ExpressionMatcher implements ValueMatcherInterface
{
    /**
     * @var RegexCollection
     */
    private $regexCollection;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->regexCollection = new RegexCollection();

        $this->regexCollection->addCollection(new TypeRegexCollection());
        $this->regexCollection->add(new RegexRegex());
    }

    public function isMatched($pattern, $value)
    {
        $extractedPatterns = [];

        $callback = function ($matches) use (&$extractedPatterns) {
            $expressionName = $matches[1];

            $callbackParameters = [];
            if (isset($matches[2])) {
                $callbackParameters = explode(',', $matches[2]);
                $callbackParameters = array_filter($callbackParameters, 'trim');
            }

            $index = count($extractedPatterns);
            $extractedPatterns[$index] = $this->regexCollection->getPattern($expressionName, $callbackParameters);
            return '~~~' . $index . '~~~';
        };

        // prepare intermediate pattern e.g. ~~~0~~~ ~~~1~~~
        $unquotedPattern = preg_replace_callback('#<([a-z\.]+)(?:\(([^\)]*)\))?>#', $callback, $pattern);

        $quotedPattern = preg_quote($unquotedPattern, '#');

        $callback = function ($matches) use ($extractedPatterns) {
            $index = $matches[1];
            return '(' . $extractedPatterns[$index] . ')';
        };

        $finalPattern = preg_replace_callback('#~~~(\d+)~~~#', $callback, $quotedPattern);

        return preg_match('#^' . $finalPattern . '$#', $value) === 1;
    }
}
