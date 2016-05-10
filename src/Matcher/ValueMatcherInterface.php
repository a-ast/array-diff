<?php

namespace Aa\ArrayDiff\Matcher;

interface ValueMatcherInterface
{
    public function isMatched($value1, $value2);
}
