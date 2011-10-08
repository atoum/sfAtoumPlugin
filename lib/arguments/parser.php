<?php

namespace sfAtoumPlugin\arguments;

class parser
{

  /**
   * @var $commandManager \sfCommandManager
   */
  protected $commandManager;

  public function __construct(\sfCommandManager $commandManager)
  {
    $this->commandManager = $commandManager;
  }

  /**
   * @return \sfCommandManager
   */
  public function getCommandManager()
  {
    return $this->commandManager;
  }

  /**
   * @param array $arguments
   * @param array $options
   *
   * @return array
   */
  public function toAtoumArguments($arguments = array(), $options = array())
  {
    $parsedArguments = array();
    foreach ($options as $name => $option)
    {
      if (in_array($name, $this->getSfOptions()))
      {
        continue;
      }
      $sfOption = $this->getCommandManager()->getOptionSet()->getOption($name);
      if ($sfOption->isArray())
      {
        foreach ($option as $value)
        {
          $parsedArguments[] = '--' . $name;
          $parsedArguments[] = $value;
        }
      }
      elseif (!$sfOption->acceptParameter())
      {
        if (true === $option)
        {
          $parsedArguments[] = '--' . $name;
        }
      }
    }
    return $parsedArguments;
  }

  /**
   * @return array
   */
  private function getSfOptions()
  {
    return array(
      'help',
      'quiet',
      'trace',
      'version',
      'color',
    );
  }

}
