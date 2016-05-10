<?php

namespace Aa\ArrayDiff\Regex;

class RegexRegex implements RegexInterface
{
    const EXCEPTION_MESSAGE = 'Expression <%s> expects 1 parameter: regular expression, e.x. (\d+).';

    public function getName()
    {
        return 'regex.regex';
    }

    public function getPattern(array $parameters)
    {
        if(1 !== count($parameters)) {
            throw new \Exception(sprintf(self::EXCEPTION_MESSAGE, $this->getName()));
        }
        
        return $parameters[0];
    }
}
