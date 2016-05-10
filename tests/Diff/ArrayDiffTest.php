<?php

namespace Aa\ArrayDiff\Tests\Diff;

use Aa\ArrayDiff\Diff\ArrayDiff;
use Aa\ArrayDiff\Diff\ArrayDiffInterface;
use Aa\ArrayDiff\Tests\YamlFixtureAwareTrait;
use PHPUnit_Framework_TestCase;

class ArrayDiffTest extends PHPUnit_Framework_TestCase
{
    use YamlFixtureAwareTrait;

    /**
     * @dataProvider fixtureDataProvider
     *
     * @param $input
     * @param $format1
     * @param $format2
     */
    public function testToArrayFormats($input, $format1, $format2)
    {
        $diff = new ArrayDiff();
        foreach ($input['missing'] as $item) {
            $diff->addMissing($item[0], $item[1]);    
        }
        foreach ($input['unmatched'] as $item) {
            $diff->addUnmatched($item[0], $item[1], $item[2]);
        }        

        $this->assertEquals($format1, $diff->toArray());
        $this->assertEquals($format2, $diff->toArray(ArrayDiffInterface::FUNCTION_FORMAT));
    }
    
    public function fixtureDataProvider()
    {
        return $this->getDataFromFixtureFile('fixtures', 'Diff');
    }
}
