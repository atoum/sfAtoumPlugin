<?php

namespace mageekguy\atoum;

require_once dirname(__FILE__) . '/../../../../lib/vendor/atoum/classes/autoloader.php';
require_once dirname(__FILE__). '/../arguments/parser.php';
require_once dirname(__FILE__). '/../arguments/builder.php';

use
  mageekguy\atoum,
  mageekguy\atoum\scripts
;


class atoumTestTask extends \sfBaseTask
{

  /**
   * @return void
   */
  protected function configure()
  {
    $this->namespace           = 'atoum';
    $this->name                = 'test';
    $this->briefDescription    = '';
    $this->detailedDescription = <<<EOF
EOF;

    $runner  = new scripts\runner(__FILE__);
    $builder = new \sfAtoumPlugin\arguments\builder($runner->getHelp());
    $builder
      ->setDefaultTypes($this->getDefaultTypes())
      ->setDefaultOptions($this->getDefaultArguments())
    ;
    $this->addOptions($builder->getSfOptions());
  }


  /**
   *
   * @param array $arguments
   * @param array $options
   *
   * @return void
   */
  protected function execute($arguments = array(), $options = array())
  {
    if (defined(__NAMESPACE__ . '\running') === false)
    {
      require_once __DIR__ . '/../classes/autoloader.php';
    }
 
    if (defined(__NAMESPACE__ . '\autorun') === false)
    {
      define(__NAMESPACE__ . '\autorun', true);

      $commandManager = new \sfCommandManager();
      $commandManager->getArgumentSet()->addArguments($this->getArguments());
      $commandManager->getOptionSet()->addOptions($this->getOptions());
       
      $options = $this->processOptions($options);

      $parser = new \sfAtoumPlugin\arguments\parser($commandManager);
      $runner = new scripts\runner(__FILE__);
      $runner->setArguments($parser->toAtoumArguments($arguments, $options));
      $runner->run();
    }

  }

   /**
    * @param array $options
    * 
    * @return array
    */
   protected function processOptions($options)
   {
     if (isset($option['testIt']) && $option['testIt'])
     {
       $options['directories'] = array();
     }
     if (count($options['directories']) > 1)
     {
       array_shift($options['directories']);
     }
     return $options;
   }

  /**
   * @return array
   */
  protected function getDefaultArguments()
  {
    return array(
      'php'              => array(\sfToolkit::getPhpCli()),
      'directories' 		 => array(\sfConfig::get('sf_test_dir') . '/unit/'),
    );
  }

   /**
    * @return array
    */
   public function getDefaultTypes()
   {
     return array(
       'no-code-coverage' => \sfCommandOption::PARAMETER_NONE,
      'testIt'            => \sfCommandOption::PARAMETER_NONE,
     );
   }

}
