<?php

namespace Aa\ArrayDiff;

use Aa\ArrayDiff\Diff\ArrayDiff;
use Aa\ArrayDiff\Diff\ArrayDiffInterface;
use Aa\ArrayDiff\Matcher\ValueMatcherInterface;

class ArrayDiffCalculator
{
    /**
     * @var ValueMatcherInterface
     */
    private $valueMatcher;

    /**
     * @var bool
     */
    private $areSequentialKeysSupported = false;

    /**
     * Constructor.
     * 
     * @param ValueMatcherInterface $valueMatcher
     */
    public function __construct(ValueMatcherInterface $valueMatcher)
    {
        $this->valueMatcher = $valueMatcher;
    }

    /**
     * Calculate diff of two arrays
     *
     * @param array $array1
     * @param array $array2
     *
     * @return ArrayDiffInterface
     */
    public function calculateDiff(&$array1, &$array2)
    {
        $keyPath = new KeyPath();
        $diff = new ArrayDiff();

        $this->internalDiff($array1, $array2, $keyPath, $diff);

        return $diff;
    }

    private function internalDiff(&$array1, &$array2, KeyPath $keyPath, ArrayDiff $diff)
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
            
            if(!isset($array2[$key])) {
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
     * @return ArrayDiffCalculator
     */
    public function setSequentialKeysSupported($value)
    {
        $this->areSequentialKeysSupported = $value;
        
        return $this;
    }
}
