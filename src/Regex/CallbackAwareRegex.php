<?php

namespace Aa\ArrayDiff\Regex;

use Closure;

class CallbackAwareRegex implements RegexInterface
{
    private $name;
    /**
     * @var Closure
     */
    private $patternBuilderCallback;

    /**
     * Constructor.
     *
     * @param $name
     * @param Closure $patternBuilderCallback
     */
    public function __construct($name, Closure $patternBuilderCallback)
    {
        $this->name = $name;
        $this->patternBuilderCallback = $patternBuilderCallback;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPattern(array $parameters)
    {
        $callback = $this->patternBuilderCallback;
        
        return $callback($parameters);
    }
}
