<?php


namespace Aa\ArrayDiff\Diff;

class Diff implements DiffInterface
{
    /**
     * @var array
     */
    private $missing = [];
    
    /**
     * @var array
     */
    private $unmatched = [];

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * Constructor.
     */
    function __construct()
    {
        $this->formatter = new Formatter();
    }

    public function addMissing($propertyPath, $expected)
    {
        $this->missing[] = [
            'key_path' => $propertyPath,
            'expected' => $expected,
        ];

        return $this;
    }

    public function addUnmatched($propertyPath, $expected, $actual)
    {
        $this->unmatched[] = [
            'key_path' => $propertyPath,
            'expected' => $expected,
            'actual' => $actual,
        ];

        return $this;
    }
    
    public function toArray($format)
    {
        return $this->formatter->toArray($this, $format);
    }

    public function toString($format)
    {
        return $this->formatter->toString($this, $format);
    }

    public function getMissing()
    {
        return $this->missing;
    }

    public function getUnmatched()
    {
        return $this->unmatched;
    }
}
