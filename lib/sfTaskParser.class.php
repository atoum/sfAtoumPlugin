<?php

use Imageekguy\atoum;

class sfTaskParser extends mageekguy\atoum\script\arguments\parser
{

  protected $task;
  protected $options;
  protected $arguments;

  public function __construct(sfTask $task, $arguments = array(), $options = array())
  {
    $this->task           = $task;
    $this->options      = $options;
    $this->arguments = $arguments;

    parent::__construct();
  }

  public function parse(array $array = null)
  {
    $this->resetValues();
    
    
    if (null !== $this->options['configuration-file'])
    {
      $this->values['-c'] = array($this->options['configuration-file']);
    }

    $this->values['-d'] = array(sfConfig::get('sf_test_dir') . '/unit/');
    $this->values['-p'] = array((null === $this->options['php']) ? sfToolkit::getPhpCli() : $this->options['php']);
    
    $this->triggerHandlers();

    return $this;
  }

  protected  function triggerHandlers()
  {
    foreach ($this->values as $argument => $values)
    {
      foreach ($this->handlers[$argument] as $handler)
      {
         $handler->__invoke($this->script, $argument, $values, sizeof($values));
      }
    }

    return $this;
  }

}
