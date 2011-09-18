<?php

namespace sfAtoumPlugin\script\arguments;

use mageekguy\atoum;

class parser extends \mageekguy\atoum\script\arguments\parser
{

  protected $options;
  protected $arguments;

  public function __construct($arguments = array(), $options = array())
  {
    $this->options   = $options;
    $this->arguments = $arguments;

    parent::__construct();
  }

  public function parse(array $array = null)
  {
    $this->resetValues();

    $this->values = $this->addValues($this->values, $this->arguments, $this->options);

    $this->triggerHandlers();

    return $this;
  }

  public function addValues(array $values, $arguments = array(), $options = array())
  {
    if (null !== $this->options['configuration-file'])
    {
      $values['-c'] = array($this->options['configuration-file']);
    }

    if ($this->options['no-code-coverage'])
    {
      $values['-ncc'] = array();
    }

    if ($options['test-it'])
    {
      $values['--testIt'] = array();
    }

    if (null !== $drt = $options['default-report-title'])
    {
      $values['-drt'] = array($drt);
    }

    if (null !== $sf = $options['score-file'])
    {
      $values['--score-file'] = array($sf);
    }

    if (null !== $mcn = $options['max-children-number'])
    {
      $values['--max-children-number'] = array($mcn);
    }

    //TODO exception if test-it and dir or file passed

    if (!$options['test-it'])
    {
      if (!count($arguments['test-file-or-dir']))
      {
        $values['-d'] = array(\sfConfig::get('sf_test_dir') . '/unit/');
      }
      else
      {
        foreach ($arguments['test-file-or-dir'] as $testOrDir)
        {
          $key = (is_dir($testOrDir)) ? '-d' : '-t';
          if (!isset($values[$key]))
          {
            $values[$key] = array();
          }
          $values[$key][] = $testOrDir;
        }

      }
    }

    $values['-p'] = array((null === $options['php']) ? \sfToolkit::getPhpCli() : $options['php']);

    return $values;
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
