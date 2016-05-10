<?php


namespace Aa\ArrayDiff\Diff;

class ArrayDiff implements ArrayDiffInterface
{
    /**
     * @var array
     */
    private $missing = [];
    
    /**
     * @var array
     */
    private $unmatched = [];


    public function addMissing($propertyPath, $expected)
    {
        $this->missing[] = [
            'key_path' => $propertyPath,
            'expected' => $expected,
        ];
    }

    public function addUnmatched($propertyPath, $expected, $actual)
    {
        $this->unmatched[] = [
            'key_path' => $propertyPath,
            'expected' => $expected,
            'actual' => $actual,
        ];
    }
    
    public function toArray($format = self::DISTINCT_FORMAT)
    {
        switch ($format) {
            case self::DISTINCT_FORMAT:
                return [
                    'missing' => $this->missing,
                    'unmatched' => $this->unmatched,
                ];
            case self::FUNCTION_FORMAT:
                $arrayDiff = [];
                foreach ($this->missing as $item) {
                    $this->setArrayValueByPath($arrayDiff, $item['key_path'], $item['expected']);
                }
                foreach ($this->unmatched as $item) {
                    $this->setArrayValueByPath($arrayDiff, $item['key_path'], $item['expected']);
                }
                return $arrayDiff;
        }
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
