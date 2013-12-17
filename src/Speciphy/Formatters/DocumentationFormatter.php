<?php
namespace Speciphy\Formatters;

class DocumentationFormatter
{
    protected $_buffer;

    protected $nPassed, $nFailed, $nPending;
    protected $failures;

    public function __construct()
    {
        $this->_buffer = '';
        $this->nPassed = $this->nFailed = $this->nPending = 0;
        $this->failures = array();
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
        $this->nPassed++;
        $this->_buffer .= "\033[32m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function exampleFailed($example)
    {
        $this->nFailed++;
        $this->failures[] = $example;
        $this->_buffer .= "\033[31m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . ' (FAILED)' . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function examplePending($example)
    {
        $this->nPending++;
        $this->_buffer .= "\033[33m";
        $this->_buffer .= str_repeat('  ', $example->getNestLevel());
        $this->_buffer .= $example->getDescription() . ' (PENDING)' . PHP_EOL;
        $this->_buffer .= "\033[0m";
    }

    public function get()
    {
        $buf = array( $this->_buffer,
          ($this->nPassed ? "\033[32m$this->nPassed passed, \033[0m" : '') .
          ($this->nPending ? "\033[33m$this->nPending pending, \033[0m" : '') .
          ($this->nFailed ? "\033[31m$this->nFailed failed" : '0 failed') );
        if ($this->nFailed) {
          $f = array_map(function($e){
            $descs = array_map(function($a){ return trim($a->getDescription()); },
              array_merge(array_reverse($e->getExampleGroup()->getAncestors()), array($e->getExampleGroup(), $e)) );
            return join(' ', $descs);
          }, $this->failures);

          $buf = array_merge($buf, array(
            "  Failures:",
            "\t" . join(PHP_EOL. "\t", $f),
            "\033[0m"
          ) );
        }
        return join(PHP_EOL.PHP_EOL, $buf);
    }
}
