<?php

namespace sfAtoumPlugin\scripts;

class runner extends \mageekguy\atoum\scripts\runner
{
	
  public static function setAutorunner($autorunner)
  {
    static::$autorunner = $autorunner;
  }

}
