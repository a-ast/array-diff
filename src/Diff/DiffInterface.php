<?php

namespace Aa\ArrayDiff\Diff;

interface DiffInterface
{
    /**
     * @param int $format
     * 
     * @return array
     */
    public function toArray($format);
}
