<?php

namespace sfAtoumPlugin\script\arguments\tests\units;

require_once dirname(__FILE__) . '/../../../../../bootstrap/unit.php';

require_once dirname(__FILE__) . '/../../../../../lib/classes/script/arguments/parser.php';

use \mageekguy\atoum;

class parser extends atoum\test
{

  public function testAddValues()
  {
    $parser = new \sfAtoumPlugin\script\arguments\parser(array(), array());
    $parser->setPhpCli('/usr/bin/php');
    $options = array(
      'test-it'              => true,
      'configuration-file'   => null,
      'no-code-coverage'     => null,
      'default-report-title' => null,
      'score-file'           => null,
      'max-children-number'  => null,
      'php'                  => null,
    );
    $values = $parser->addValues(array(), array(), $options);
    $expected = array(
      '--testIt' => array(),
      '-p'       => array('/usr/bin/php')
    );
    $this->assert->phpArray($values)->isEqualTo($expected);
  }

}
