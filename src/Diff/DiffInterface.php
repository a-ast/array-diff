<?php

namespace Aa\ArrayDiff\Diff;

interface DiffInterface
{
    public function getMissing();

    public function getUnmatched();

    /**
     * @param string $format
     * 
     * @return array
     */
    public function toArray($format = '');

    /**
     * @param string $format
     *
     * @return string
     */
    public function toString($format = '');


}
