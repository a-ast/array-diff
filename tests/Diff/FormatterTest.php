<?php

namespace Aa\ArrayDiff\Tests\Diff;

use Aa\ArrayDiff\Diff\ArrayDiff;
use Aa\ArrayDiff\Diff\DiffFormats;
use Aa\ArrayDiff\Diff\Formatter;
use PHPUnit_Framework_TestCase;

class FormatterTest extends PHPUnit_Framework_TestCase
{
    public function test_to_string()
    {
        $diff = new ArrayDiff();
        $diff
            ->addMissing('Team', 'The Fellowship Of The Ring')
            ->addMissing('Members/Hobbits/Hobbit1', 'Bilbo Baggins')
            ->addUnmatched('Members/Hobbits/Hobbit2', 'Frodo Baggins', 'Freddie Baggins')
            ->addUnmatched('FoundationPlace', 'Rivendell', 'Hobbiton')
        ;

        $formatter = new Formatter();
        $result = $formatter->toString($diff, DiffFormats::FULL_YAML);

        $expected = <<<EOD
missing:
    -
        key_path: Team
        expected: 'The Fellowship Of The Ring'
    -
        key_path: Members/Hobbits/Hobbit1
        expected: 'Bilbo Baggins'
unmatched:
    -
        key_path: Members/Hobbits/Hobbit2
        expected: 'Frodo Baggins'
        actual: 'Freddie Baggins'
    -
        key_path: FoundationPlace
        expected: Rivendell
        actual: Hobbiton

EOD;

        $this->assertEquals($expected, $result);
    }
}
