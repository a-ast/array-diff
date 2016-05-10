<?php

namespace Aa\ArrayDiff\Tests\Regex;

use Aa\ArrayDiff\Regex\TypeRegexCollection;
use PHPUnit_Framework_TestCase;

class TypeRegexCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testFloatPatterns()
    {
        $collection = new TypeRegexCollection();

        $floatRegex = $collection->getPattern('type.float', []);
        $this->assertRegExp('#^'.$floatRegex.'$#', '0');
        $this->assertRegExp('#^'.$floatRegex.'$#', '0.00');
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456');
        $this->assertRegExp('#^'.$floatRegex.'$#', '-123456');
        $this->assertRegExp('#^'.$floatRegex.'$#', '+123456');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '0123456');
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456.123456');
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456.012');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456.');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '0123456.016');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '.016');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '@123456');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', 'string');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', 'string.text');

        $floatRegex = $collection->getPattern('type.float', ['', ',']);
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456,123456');
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456,012');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456,');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '0123456,016');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', ',016');

        $floatRegex = $collection->getPattern('type.float', [2]);
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456.12');
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456.00');
        $this->assertRegExp('#^'.$floatRegex.'$#', '-123456.12');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '0123456.12');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456.123');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456.1');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '-123456.1');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '+123456.1');

        $floatRegex = $collection->getPattern('type.float', [2, ',']);
        $this->assertRegExp('#^'.$floatRegex.'$#', '123456,12');
        $this->assertRegExp('#^'.$floatRegex.'$#', '-123456,12');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '0123456,12');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456,123');
        $this->assertNotRegExp('#^'.$floatRegex.'$#', '123456,1');
    }

    public function testIntegerPatterns()
    {
        $collection = new TypeRegexCollection();

        $regex = $collection->getPattern('type.integer', []);
        $this->assertRegExp('#^'.$regex.'$#', '0');
        $this->assertRegExp('#^'.$regex.'$#', '123456');
        $this->assertRegExp('#^'.$regex.'$#', '-123456');
        $this->assertRegExp('#^'.$regex.'$#', '+123456');
        $this->assertNotRegExp('#^'.$regex.'$#', '@123456');
        $this->assertNotRegExp('#^'.$regex.'$#', '1s3456');
    }

    public function testStringPatterns()
    {
        $collection = new TypeRegexCollection();

        $regex = $collection->getPattern('type.string', []);
        $this->assertRegExp('#^'.$regex.'$#', 'text');
        $this->assertRegExp('#^'.$regex.'$#', '123');
        $this->assertRegExp('#^'.$regex.'$#', '(\d+)');
    }

    public function testBooleanPatterns()
    {
        $collection = new TypeRegexCollection();

        $regex = $collection->getPattern('type.boolean', []);
        $this->assertRegExp('#^'.$regex.'$#', 'true');
        $this->assertRegExp('#^'.$regex.'$#', 'false');
        $this->assertNotRegExp('#^'.$regex.'$#', 'null');
    }

    public function testEmailPatterns()
    {
        $collection = new TypeRegexCollection();

        $regex = $collection->getPattern('type.email', []);
        $this->assertRegExp('#^'.$regex.'$#', 'aa@aa.com');
        $this->assertRegExp('#^'.$regex.'$#', 'aa@10.10.123.234');
        $this->assertRegExp('#^'.$regex.'$#', 'aa.bb@aa');
        $this->assertRegExp('#^'.$regex.'$#', '123@aa');
        $this->assertNotRegExp('#^'.$regex.'$#', 'abcdef');
        $this->assertNotRegExp('#^'.$regex.'$#', 'aa#aa.aa');
    }

    public function testDateTimePatterns()
    {
        $collection = new TypeRegexCollection();

        $regex = $collection->getPattern('type.datetime', []);
        $this->assertRegExp('#^'.$regex.'$#', '1978-12-18 23:30:00');
        $this->assertRegExp('#^'.$regex.'$#', '2016-01-01 00:00:00');
        $this->assertRegExp('#^'.$regex.'$#', '2016-12-31 23:59:59');
        
        $this->assertNotRegExp('#^'.$regex.'$#', '2016-13-01 00:00:00');
        $this->assertNotRegExp('#^'.$regex.'$#', '2016-12-32 00:00:00');
        $this->assertNotRegExp('#^'.$regex.'$#', '2016-12-31 24:00:00');
        $this->assertNotRegExp('#^'.$regex.'$#', '2016-12-31 23:59:60');
        
        $this->assertNotRegExp('#^'.$regex.'$#', '1978/12/18 23:30:00');
        $this->assertNotRegExp('#^'.$regex.'$#', 'not a date');
    }
}
