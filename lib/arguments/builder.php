<?php
namespace sfAtoumPlugin\arguments; //parser

use
  mageekguy\atoum,
  mageekguy\atoum\scripts
;

class builder
{

  /**
   * @var array
   */
  protected $runnerHelp;

  /**
   * @var array
   */
  protected $defaultTypes = array();

  /**
   * @var array
   */
  protected $defaultOptions = array();

  /**
   * @param scripts\runner $runner
   */
  public function __construct(array $runnerHelp)
  {
    $this->runnerHelp = $runnerHelp;
  }

  /**
   * @return array
   */
  public function getRunnerHelp()
  {
    return $this->runnerHelp;
  }

  /**
   * @return array
   */
  public function getSfOptions()
  {
    $sfOptions = array();
    foreach ($this->getRunnerHelp() as $help)
    {
      $name     = null;
      $optHelp  = null;
      $shortcut = null;
      foreach ($help[0] as $parameter)
      {
        if (\substr($parameter, 0, 2) == '--')
        {
          $name = \substr($parameter, 2);
        }
        elseif (\substr($parameter, 0, 1) == '-')
        {
          $shortcut = \substr($parameter, 1);
          if (strlen($shortcut) > 1 || $shortcut == 't')
          {
            $shortcut = null;
          }
        }
      }
      if (isset($help[2]))
      {
        $optHelp = $help[2];
      }
      if (null !== $name)
      {
        $atoumOptions[] = array('name' => $name, 'shortcut' => $shortcut, 'help' => $optHelp);
      }
    }

    $defaultType = \sfCommandOption::PARAMETER_OPTIONAL | \sfCommandOption::IS_ARRAY;

    $ignoredOptions = array(
      'help',
      'version',
    );

    $defaultTypes  = $this->getDefaultTypes();
    $defaultValues = $this->getDefaultOptions();

    foreach ($atoumOptions as $option)
    {
      $name = $option['name'];
      if (in_array($option['name'], $ignoredOptions))
      {
        continue;
      }
      
      $type = $defaultType;
      $default = null;
      if (array_key_exists($name, $defaultValues))
      {
        $default = $defaultValues[$name];
      }
      if (array_key_exists($name, $defaultTypes))
      {
        $type = $defaultTypes[$name];
      }
      $sfOptions[] = new \sfCommandOption($name, $option['shortcut'], $type, $option['help'], $default);
    }
    return $sfOptions;
  }

  /**
   * @return array
   */
  public function getDefaultTypes()
  {
    return $this->defaultTypes;
  }

  /**
   * @param array $defaultTypes
   *
   * @return builder
   */
  public function setDefaultTypes(array $defaultTypes)
  {
    $this->defaultTypes = $defaultTypes;

    return $this;
  }

  /**
   * @return array
   */
  public function getDefaultOptions()
  {
    return $this->defaultOptions;
  }

  /**
   * @param array $defaultOptions
   *
   * @return builder
   */
  public function setDefaultOptions(array $defaultOptions)
  {
    $this->defaultOptions = $defaultOptions;

    return $this;
  }

}
