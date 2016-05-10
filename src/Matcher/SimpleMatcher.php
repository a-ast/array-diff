<?php

namespace Aa\ArrayDiff\Matcher;

class SimpleMatcher implements ValueMatcherInterface
{
    public function isMatched($value1, $value2)
    {
        return ($value1 === $value2);
    }
}
