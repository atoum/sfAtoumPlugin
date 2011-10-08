<?php

namespace sfAtoumPlugin\arguments\tests\units;

require_once dirname(__FILE__) . '/../../../bootstrap/unit.php';

require_once dirname(__FILE__) . '/../../../lib/arguments/builder.php';

use \mageekguy\atoum;

class builder extends atoum\test
{

  public function testAddValues()
  {
    $help =  array(
      0 => 
        array (
          0 => 
          array (
            0 => '-c',
            1 => '--configuration-files',
          ),
          1 => '<files>',
          2 => 'Use configuration <files>',
        ),
    );

    $builder = new \sfAtoumPlugin\arguments\builder($help);
    $values = $builder->getSfOptions();
    $expectes = new \sfCommandOption('configuration-files', 'c', sfCommandOption::PARAMETER_OPTIONAL | \sfCommandOption::IS_ARRAY, 'Use configuratin <files>');
    $this->assert->phpArray($values)->isEqualTo($expected);
  }

}
