<?php

namespace sfAtoumPlugin\wrapper;

require_once __DIR__ . '/exception/noDefaultValueException.php';

class arguments
{

  protected $defaultValues;

  public function __construct(array $defaultValues = array())
  {
    $this->setDefaultValues($defaultValues);
  }

  public function setDefaultValues(array $defaultValues = null)
  {
    $this->defaultValues = $defaultValues;

    return $this;
  }

  public function getArguments($arguments = array(), $options = array())
  {
    $return = array();
    if (isset($options['configuration-file']) && null !== $options['configuration-file'])
    {
      $return[] = '-c';
      $return[] = $options['configuration-file'];
    }

    if (isset($options['no-code-coverage']) && $options['no-code-coverage'])
    {
      $return[] = '-ncc';
    }

    if (isset($options['test-it']) && $options['test-it'])
    {
      $return[] = '--testIt';
    }

    if (isset($options['default-report-title']) && null !== $drt = $options['default-report-title'])
    {
      $return[] = '-drt';
      $return[] = $drt;
    }

    if (isset($options['score-file']) && null !== $sf = $options['score-file'])
    {
      $return[] = '--score-file';
      $return[] = $sf;
    }

    if (isset($options['max-children-number']) && null !== $mcn = $options['max-children-number'])
    {
      $return[] = '--max-children-number';
      $return[] = $mcn;
    }


    if (isset($options['test-it']) && !$options['test-it'])
    {
      if (isset($arguments['test-file-or-dir']) && !count($arguments['test-file-or-dir'])
       || !isset($arguments['test-file-or-dir']))
      {
        $return[] = '-d';
        $return[] = $this->getDefaultValue('test-file-or-dir');
      }
      else
      {
        foreach ($arguments['test-file-or-dir'] as $testOrDir)
        {
          $return[] = (is_dir($testOrDir)) ? '-d' : '-t';
          $return[] = $testOrDir;
        }

      }
    }

    $return[] = '--php';
    if ((isset($options['php']) && !count($options['php'])) || !isset($options['php']))
    {
      $return[] = $this->getDefaultValue('php');
    }
    else
    {
      $return[] = $options['php'];
    }

    return $return;
  }

  public function getDefaultValue($name)
  {
    if (!isset($this->defaultValues[$name]))
    {
      throw new arguments\noDefaultValueException(sprintf('No Default value for %s', $name));
    }
    return $this->defaultValues[$name];
  }

}
