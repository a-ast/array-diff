<?php

namespace Aa\ArrayDiff\Regex;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class RegexCollection implements IteratorAggregate, Countable
{
    /**
     * @var CallbackAwareRegex[]
     */
    private $collection = [];
    
    
    public function add(RegexInterface $regex)
    {
        $this->collection[$regex->getName()] = $regex;
    }

    public function addCollection(RegexCollection $collection)
    {
        foreach ($collection as $item) {
            $this->add($item);
        }
    }

    public function getPattern($name, $parameters)
    {
        if (!isset($this->collection[$name])) {
            return '';
        }

        return $this->collection[$name]->getPattern($parameters);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->collection);
    }
}
