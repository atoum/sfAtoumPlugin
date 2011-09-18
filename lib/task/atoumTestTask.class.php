<?php

namespace mageekguy\atoum;

require_once dirname(__FILE__) . '/../vendor/atoum/classes/autoloader.php';
require_once dirname(__FILE__). '/../classes/scripts/runner.class.php';

use
  mageekguy\atoum,
  mageekguy\atoum\scripts
;


class atoumTestTask extends \sfBaseTask
{
  protected function configure()
  {
    $this->namespace           = 'atoum';
    $this->name                = 'test';
    $this->briefDescription    = '';
    $this->detailedDescription = <<<EOF
EOF;
    $this->addOption('configuration-file', 'c', \sfCommandOption::PARAMETER_OPTIONAL, 'config file');
    $this->addOption('php', 'p', \sfCommandOption::PARAMETER_OPTIONAL, 'path to php binary');
    $this->addOption('default-report-title', 'd', \sfCommandOption::PARAMETER_OPTIONAL, 'Define default report title');
    $this->addOption('score-file', 's', \sfCommandOption::PARAMETER_OPTIONAL, 'Save score in <file>');
    $this->addOption('max-children-number', 'm', \sfCommandOption::PARAMETER_OPTIONAL, 'Maximum number of sub-processus which will be run simultaneously');
    $this->addOption('no-code-coverage', 'n', \sfCommandOption::PARAMETER_NONE, 'disable code coverage');
    $this->addOption('test-it', null, \sfCommandOption::PARAMETER_NONE, 'execute all atoum unit tests');
    $this->addArgument('test-file-or-dir', \sfCommandArgument::OPTIONAL | \sfCommandArgument::IS_ARRAY, 'path to test files or folders');
  }

  protected function execute($arguments = array(), $options = array())
  {
    if (defined(__NAMESPACE__ . '\running') === false)
    {
      require_once __DIR__ . '/../classes/autoloader.php';
    }
 
    if (defined(__NAMESPACE__ . '\autorun') === false)
    {
      define(__NAMESPACE__ . '\autorun', true);

      /**
       *
       * We need to do that because we can't injet an argumentParser to the autorun method
       * so, we have to set the runner because it won't be accesible if we do that in a config file :
       *  atoum\scripts\runner::getAutorunner()
      */

      $runner = new scripts\runner(__FILE__);

      $runner->setArgumentsParser(new \sfTaskParser($this, $arguments, $options));

      \sfAtoumPlugin\scripts\runner::setAutorunner($runner);

      $runner->run();
    }

  }

}
