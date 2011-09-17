<?php

namespace mageekguy\atoum;

require_once dirname(__FILE__) . '/../lib/vendor/atoum/classes/autoloader.php';
require_once dirname(__FILE__). '/../classes/scripts/runner.class.php';

use
  mageekguy\atoum,
  mageekguy\atoum\scripts
;


class atoumTestTask extends \sfBaseTask
{
  protected function configure()
  {
    $this->namespace             = 'atoum';
    $this->name                       = 'test';
    $this->briefDescription       = '';
    $this->detailedDescription = <<<EOF
EOF;
    $this->addOption('configuration-file', 'c', \sfCommandOption::PARAMETER_OPTIONAL, 'config file');
    $this->addOption('php', 'p', \sfCommandOption::PARAMETER_OPTIONAL, 'path to php binary');
    //TODO
    //-ncc, --no-code-coverage' => $this->locale->_('Disable code coverage')
    //-mcn, --max-children-number <integer>' => $this->locale->_('Maximum number of sub-processus which will be run simultaneously')
    //-sf <file>, --score-file <file>' => $this->locale->_('Save score in <file>')
    //-t <files>, --test-files <files>' => $this->locale->_('Use test files'),$
    //-d <directories>, --directories <directories>' => $this->locale->_('Use test files in <directories>'),$
    //'-drt <string>, --default-report-title <string>' => $this->locale->_('Define default report title'),$
    //--testIt' => $this->locale->_('Execute all atoum unit tests')$
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

      $runner = new scripts\runner('test');

      $runner->setArgumentsParser(new \sfTaskParser($this, $arguments, $options));

      \sfAtoumPlugin\scripts\runner::setAutorunner($runner);

      $runner->run();
    }

  }

}
