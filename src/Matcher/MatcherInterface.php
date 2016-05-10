<?php

namespace Aa\ArrayDiff\Matcher;

interface MatcherInterface
{
    public function isMatched($value1, $value2);
}
