<?php
namespace Speciphy\Formatters;

class ProgressFormatter
{
    protected $_fp;

    public function __construct($fp)
    {
        $this->_fp = $fp;
    }

    public function exampleGroupStarted($group)
    {}

    public function exampleStarted($example)
    {}

    public function examplePassed($example)
    {
        fputs($this->_fp, "\033[32m.\033[0m");
    }

    public function exampleFailed($example)
    {
        fputs($this->_fp, "\033[1;31mF\033[0m");
    }

    public function examplePending($example)
    {
        fputs($this->_fp, "\033[33mP\033[0m");
    }
}
