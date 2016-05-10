<?php


namespace Aa\ArrayDiff\Regex;

use Closure;

class TypeRegexCollection extends RegexCollection
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->addClosureBasedRegex('type.string', function () {
            return '.*';
        });

        $this->addClosureBasedRegex('type.integer', function () {
            return '(\+|\-)?(0|[1-9][0-9]*)';
        });

        $this->addClosureBasedRegex('type.float', function ($parameters) {
            $precision = isset($parameters[0]) && '' !== $parameters[0] ? $parameters[0] : '1,';
            $decimalPoint = isset($parameters[1]) && '' !== $parameters[1] ? $parameters[1] : '.';
            return sprintf('(\+|\-)?(0|[1-9][0-9]*)(%s[0-9]{%s})?', preg_quote($decimalPoint), $precision);
        });

        $this->addClosureBasedRegex('type.boolean', function () {
            return 'true|false|0|1';
        });

        $this->addClosureBasedRegex('type.email', function () {
            return '[[:alnum:].]+@[[:alnum:].]+';
        });

        $this->addClosureBasedRegex('type.datetime', function () {
            return '(\d{2}|\d{4})(?:\-)?([0]{1}\d{1}|[1]{1}[0-2]{1})(?:\-)?([0-2]{1}\d{1}|[3]{1}[0-1]{1})(?:\s)?([0-1]{1}\d{1}|[2]{1}[0-3]{1})(?::)?([0-5]{1}\d{1})(?::)?([0-5]{1}\d{1})';
        });
    }

    public function addClosureBasedRegex($name, Closure $patternBuilderCallback)
    {
        $this->add(new CallbackAwareRegex($name, $patternBuilderCallback));
    }
}
