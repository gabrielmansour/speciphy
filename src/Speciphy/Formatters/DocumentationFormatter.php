<?php
namespace Speciphy\Formatters;

class DocumentationFormatter
{
    protected $_buffer;

    public function __construct()
    {
        $this->_buffer = '';
    }

    public function exampleGroupStarted($group)
    {
        $this->_buffer .= "\033[2m";
        $this->_buffer .= str_repeat('  ', $group->getNestLevel());
        $this->_buffer .= $group->getDescription() . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function exampleStarted($example)
    {}

    public function examplePassed($example)
    {
        $this->_buffer .= "\033[32m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function exampleFailed($example)
    {
        $this->_buffer .= "\033[31m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . ' (FAILED)' . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function examplePending($example)
    {
        $this->_buffer .= "\033[33m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . ' (PENDING)' . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function get()
    {
        return $this->_buffer;
    }
}
