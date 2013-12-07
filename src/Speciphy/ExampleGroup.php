<?php
namespace Speciphy;

use Speciphy\ExampleInterface;

class ExampleGroup
{
    /**
     * Text represents this ExampleGroup.
     *
     * @var string
     */
    protected $_description;

    /**
     * Set of examples.
     *
     * @var array
     */
    protected $_examples;

    /**
     * Outer ExampleGroup.
     *
     * @var ExampleGroup
     */
    protected $_parent;

    /**
     * Subject under test.
     *
     * @var Speciphy\Subject
     */
    protected $_subject;

    /**
     * Set of let statements.
     *
     * @var array
     */
    protected $_lets;

    /**
     * Constructor.
     *
     * @param string $description
     */
    public function __construct($description)
    {
        $this->_description = $description;
        $this->_examples    = array();
        $this->_lets    = array();
    }

    /**
     * Gets the description of this.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Adds a child of this and be its parent.
     *
     * @param  ExampleInterfae $example
     * @return void
     */
    public function addChild($child)
    {
        $child->setParent($this);
        $this->_examples[] = $child;
    }

    public function getExamples()
    {
        return $this->_examples;
    }

    public function setParent($parent)
    {
        $this->_parent = $parent;
    }

    public function getAncestors()
    {
        if (isset($this->_parent)) {
            return array_merge(array($this->_parent), $this->_parent->getAncestors());
        } else {
            return array();
        }
    }

    public function run($reporter)
    {
        $this->_reporter = $reporter;
        $reporter->exampleGroupStarted($this);
        $this->runBeforeAllHooks();
        foreach ($this->getExamples() as $example) {
            $example->run($reporter);
        }
        $this->runAfterAllHooks();
    }

    public function runBeforeAllHooks()
    {}

    public function runAfterAllHooks()
    {}

    public function runBeforeHooks()
    {
      // set lets
      foreach ($this->getlets() as $let) {
        $name = $let->_name;
        $value = $let->_value;
        global $$name;
        $$name = (is_callable($value) ? call_user_func($value) : $value);
      }
    }

    public function runAfterHooks()
    {
      // Unset lets
      foreach ($this->getLets() as $let) {
        unset($GLOBALS[$let->_name]);
      }
    }

    public function setSubject(Subject $subject)
    {
        $this->_subject = $subject;
    }

    public function getSubject()
    {
        if (isset($this->_subject)) {
            return $this->_subject;
        } else if (isset($this->_parent)) {
            return $this->_parent->getSubject();
        } else {
            return NULL;
        }
    }

    public function addLet(Let $let)
    {
        $this->_lets[] = $let;
    }

    public function getLets(){
      $lets = $this->_lets;
      if ($this->_parent)
        $lets = array_merge($this->_parent->getLets(), $lets);

      return $lets;
    }

    /**
     * Gets the nest level.
     *
     * @return int
     */
    public function getNestLevel()
    {
        return isset($this->_parent) ? $this->_parent->getNestLevel() + 1 : 0;
    }

    public function isExampleGroup()
    {
        return true;
    }
}
