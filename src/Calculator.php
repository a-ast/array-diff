<?php

namespace Aa\ArrayDiff;

use Aa\ArrayDiff\Diff\Diff;
use Aa\ArrayDiff\Diff\DiffInterface;
use Aa\ArrayDiff\Matcher\MatcherInterface;

class Calculator
{
    /**
     * @var MatcherInterface
     */
    private $valueMatcher;

    /**
     * @var bool
     */
    private $areSequentialKeysSupported = false;

    /**
     * Constructor.
     * 
     * @param MatcherInterface $valueMatcher
     */
    public function __construct(MatcherInterface $valueMatcher)
    {
        $this->valueMatcher = $valueMatcher;
    }

    /**
     * Calculate diff of two arrays
     *
     * @param array $array1
     * @param array $array2
     *
     * @return DiffInterface
     */
    public function calculateDiff(&$array1, &$array2)
    {
        $keyPath = new KeyPath();
        $diff = new Diff();

        $this->internalDiff($array1, $array2, $keyPath, $diff);

        return $diff;
    }

    private function internalDiff(&$array1, &$array2, KeyPath $keyPath, Diff $diff)
    {
        foreach ($array1 as $key => &$item) {

            $keyPath->push($key);

            if($this->areSequentialKeysSupported()) {
                if (is_int($key) && !is_array($item)) {
                    if (!in_array($item, $array2)) {
                        // element is not present in sequential array
                        $diff->addMissing($keyPath->getPathString(), $item);
                    }
                    $keyPath->pop();
                    continue;
                }
            }
            
            if(!array_key_exists($key, $array2)) {
                $diff->addMissing($keyPath->getPathString(), $item);
                
                $keyPath->pop();
                continue;
            }

            if(is_array($item)) {
                $this->internalDiff($item, $array2[$key], $keyPath, $diff);
                
                $keyPath->pop();
                continue;
            }

            $matchingItem = $array2[$key];

            if(false === $this->valueMatcher->isMatched($item, $matchingItem)) {
                $diff->addUnmatched($keyPath->getPathString(), $item, $matchingItem);
            }

            $keyPath->pop();
        }
    }

    private function areSequentialKeysSupported()
    {
        return $this->areSequentialKeysSupported;
    }

    /**
     * @param boolean $value
     * 
     * @return Calculator
     */
    public function setSequentialKeysSupported($value)
    {
        $this->areSequentialKeysSupported = $value;
        
        return $this;
    }
}
