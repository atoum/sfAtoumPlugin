<?php

namespace sfAtoumPlugin\wrapper\tests\units;

require_once dirname(__FILE__) . '/../../../bootstrap/unit.php';

require_once dirname(__FILE__) . '/../../../lib/wrapper/arguments.php';

use \mageekguy\atoum;

class arguments extends atoum\test
{

  public function testAddValues()
  {
    $defaultValues = array(
      'php' => '/usr/bin/php',
    );
    $parser = new \sfAtoumPlugin\wrapper\arguments($defaultValues);
    $options = array(
      'test-it'              => true,
      'configuration-file'   => null,
      'no-code-coverage'     => null,
      'default-report-title' => null,
      'score-file'           => null,
      'max-children-number'  => null,
      'php'                  => null,
    );
    $values = $parser->getArguments(array(), $options);
    $expected = array(
      '--testIt',
      '--php',
      '/usr/bin/php',
    );
    $this->assert->phpArray($values)->isEqualTo($expected);
  }

  public function testNoDefaultValue()
  {
    $parser = new \sfAtoumPlugin\wrapper\arguments();
    $this->assert->exception(function () use($parser) {
      $parser->getArguments();
    })->isInstanceOf('\sfAtoumPlugin\wrapper\arguments\noDefaultValueException', 'exception if no default php')
      ->hasMessage('No Default value for php');
    ;
  }

}
