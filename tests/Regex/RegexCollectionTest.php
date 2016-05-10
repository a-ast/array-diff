<?php

namespace Aa\ArrayDiff\Tests\Regex;

use Aa\ArrayDiff\Regex\RegexCollection;
use Aa\ArrayDiff\Regex\RegexInterface;
use PHPUnit_Framework_TestCase;

class RegexCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testAddItem()
    {
        $collection = new RegexCollection();
        $collection->add(new RegexMock(1));
        
        $this->assertCount(1, $collection);
    }

    public function testIterateCollection()
    {
        $collection = new RegexCollection();
        $collection->add(new RegexMock(1));
        $collection->add(new RegexMock(2));

        foreach ($collection as $item) {
            $this->assertInstanceOf('\Aa\ArrayDiff\Regex\RegexInterface', $item);
        }
    }

    public function testAddCollection()
    {
        $collection1 = new RegexCollection();
        $collection1->add(new RegexMock(1));
        $collection1->add(new RegexMock(2));

        $collection2 = new RegexCollection();
        $collection2->add(new RegexMock(3));
        $collection2->add(new RegexMock(4));
        $collection2->add(new RegexMock(5));

        $collection1->addCollection($collection2);

        $this->assertCount(5, $collection1);
    }

    public function testGetPatternReturnsEmptyStringIfRegexNotAdded()
    {
        $collection = new RegexCollection();
        $this->assertEmpty($collection->getPattern('name', []));
    }

    public function testGetPattern()
    {
        $collection = new RegexCollection();
        $collection->add(new RegexMock(1));
        $this->assertEquals('param', $collection->getPattern(1, ['param']));
    }
}

class RegexMock implements RegexInterface
{

    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPattern(array $parameters)
    {
        return $parameters[0];
    }
}
