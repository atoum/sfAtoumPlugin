<?php

$_test_dir = realpath(dirname(__FILE__).'/..');

// configuration
require_once dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::hasActive() ? ProjectConfiguration::getActive() : new ProjectConfiguration(realpath($_test_dir.'/../../'));

// autoloader
$autoload = sfSimpleAutoload::getInstance(sfConfig::get('sf_cache_dir').'/project_autoload.cache');
$autoload->loadConfiguration(sfFinder::type('file')->name('autoload.yml')->in(array(
  sfConfig::get('sf_symfony_lib_dir').'/config/config',
  sfConfig::get('sf_config_dir'),
)));
$autoload->register();

if (defined('\mageekguy\atoum\running') === false)
{
  if (null === $atoumPath = sfConfig::get('sf_atoum_path'))
  {
    $atoumPath = dirname(__FILE__) . '/../../../lib/vendor/atoum/';
  }
  require_once $atoumPath . '/classes/autoloader.php';
}

if (defined('mageekguy\atoum\autorun') === false)
{
  define('mageekguy\atoum\autorun', true);
  \mageekguy\atoum\scripts\runner::autorun('runner');
}

