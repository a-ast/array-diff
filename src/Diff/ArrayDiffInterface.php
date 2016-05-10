<?php

namespace Aa\ArrayDiff\Diff;

interface ArrayDiffInterface
{
    /**
     * @param int $format
     * 
     * @return array
     */
    public function toArray($format);
}
