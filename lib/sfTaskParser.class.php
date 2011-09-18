<?php

use Imageekguy\atoum;

class sfTaskParser extends mageekguy\atoum\script\arguments\parser
{

  protected $task;
  protected $options;
  protected $arguments;

  public function __construct(sfTask $task, $arguments = array(), $options = array())
  {
    $this->task      = $task;
    $this->options   = $options;
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

    if ($this->options['no-code-coverage'])
    {
      $this->values['-ncc'] = array();
    }

    if ($this->options['test-it'])
    {
      $this->values['--testIt'] = array();
    }

    if (null !== $drt = $this->options['default-report-title'])
    {
      $this->values['-drt'] = array($drt);
    }

    if (null !== $sf = $this->options['score-file'])
    {
      $this->values['--score-file'] = array($sf);
    }

    if (null !== $mcn = $this->options['max-children-number'])
    {
      $this->values['--max-children-number'] = array($mcn);
    }

    //TODO exception if test-it and dir or file passed

    if (!$this->options['test-it'])
    {
      if (!count($this->arguments['test-file-or-dir']))
      {
        $this->values['-d'] = array(sfConfig::get('sf_test_dir') . '/unit/');
      }
      else
      {
        foreach ($this->arguments['test-file-or-dir'] as $testOrDir)
        {
          $key = (is_dir($testOrDir)) ? '-d' : '-t';
          if (!isset($this->values[$key]))
          {
            $this->values[$key] = array();
          }
          $this->values[$key][] = $testOrDir;
        }

      }
    }
    
    $this->values['-p'] = array((null === $this->options['php']) ? sfToolkit::getPhpCli() : $this->options['php']);
    
    $this->triggerHandlers();

    return $this;
  }

  protected function triggerHandlers()
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
