<?php

namespace Aa\ArrayDiff\Regex;

interface RegexInterface
{
    public function getName();

    public function getPattern(array $parameters);
}
