<?php

namespace Aa\ArrayDiff\Diff;

use Symfony\Component\Yaml\Yaml;

class Formatter
{
    public function toArray(ArrayDiff $diff, $format)
    {
        switch ($format) {
            case DiffFormats::FULL:
                return [
                    'missing' => $diff->getMissing(),
                    'unmatched' => $diff->getUnmatched(),
                ];
            case DiffFormats::PHP_FUNCTION_ALIKE:
                $arrayDiff = [];
                foreach ($diff->getMissing() as $item) {
                    $this->setArrayValueByPath($arrayDiff, $item['key_path'], $item['expected']);
                }
                foreach ($diff->getUnmatched() as $item) {
                    $this->setArrayValueByPath($arrayDiff, $item['key_path'], $item['expected']);
                }
                return $arrayDiff;
        }
    }

    public function toString(ArrayDiff $diff, $format)
    {
        return Yaml::dump($this->toArray($diff, DiffFormats::FULL), 3);
    }

    private function setArrayValueByPath(&$source, $propertyPath, &$value)
    {
        $propertyPathArray = explode('/', $propertyPath);

        $temp = &$source;
        foreach($propertyPathArray as $key) {
            $temp = &$temp[$key];
        }
        $temp = $value;
        unset($temp);
    }
}
