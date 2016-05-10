<?php

namespace Aa\ArrayDiff\Diff;

interface ArrayDiffInterface
{
    const DISTINCT_FORMAT = 1;
    const FUNCTION_FORMAT = 2;

    /**
     * @param int $format
     * 
     * @return array
     */
    public function toArray($format = self::DISTINCT_FORMAT);
}
