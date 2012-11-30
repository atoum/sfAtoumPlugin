# *sfAtoumPlugin*

##Install

### Using composer

Add this to you dependencies in your composer.json ([example](https://gist.github.com/3006430)) : 

```
  "require"     : {
    "atoum/sfAtoumPlugin": "*"
  },
```

After a 

`php composer.phar update`

The plugin should be in the plugin folder and atoum in the vendor folder.

Then in your ProjectConfiguration file you have to activate the plugin and define the atoum path.

``` php
  sfConfig::set('sf_atoum_path', dirname(__FILE__) . '/../vendor/atoum/atoum');

  if (sfConfig::get('sf_environment') != 'prod')
  {
    $this->enablePlugins('sfAtoumPlugin');
  }
```


### Using a git submodule

Install atoum as a submodule

`git submodule add git://github.com/atoum/atoum.git lib/vendor/atoum`


Install sfAtoumPlugin as a git submodule

`git submodule add git://github.com/agallou/sfAtoumPlugin.git plugins/sfAtoumPlugin`


Add the plugin in your ProjectConfiguration file

``` php

  if (sfConfig::get('sf_environment') != 'prod')
  {
    $this->enablePlugins('sfAtoumPlugin');
  }
```


##Launch tests

`php symfony atoum:test`

You can pass a configuration file (see here for how to write the configuration file : https://github.com/atoum/atoum/wiki/atoum-et-Jenkins-(ou-Hudson) )
via the -c option :

`php symfony atoum:test -c config/atoum/hudson.php`



All atoum options are available :

```
 ./symfony help atoum:test

Usage:
 symfony atoum:test [-p|--php[="..."]] [--default-report-title[="..."]] [-c|--configurations[="..."]] [--score-file[="..."]] [--max-children-number[="..."]] [--no-code-coverage] [--no-code-coverage-in-directories[="..."]] [--no-code-coverage-for-namespaces[="..."]] [--no-code-coverage-for-classes[="..."]] [-f|--files[="..."]] [-d|--directories[="..."]] [--test-file-extensions[="..."]] [-g|--glob[="..."]] [--tags[="..."]] [-m|--methods[="..."]] [--namespaces[="..."]] [-l|--loop] [--test-it[="..."]] [--test-all[="..."]] [--force-terminal[="..."]] [--bootstrap-file[="..."]] [--use-light-report[="..."]] [--debug[="..."]]

Arguments:
 test-file-or-dir        path to test files or folders

Options:
 --php                              (-p) Path to PHP binary which must be used to run tests (default: Array(    [0] => /usr/bin/php5)) (multiple values allowed)
 --default-report-title             Define default report title with <string> (multiple values allowed)
 --configurations                   (-c) Use all configuration files <file> (multiple values allowed)
 --score-file                       Save score in file <file> (multiple values allowed)
 --max-children-number              Maximum number of sub-processus which will be run simultaneously (multiple values allowed)
 --no-code-coverage                 Disable code coverage
 --no-code-coverage-in-directories  Disable code coverage in directories <directory> (multiple values allowed)
 --no-code-coverage-for-namespaces  Disable code coverage for namespaces <namespace> (multiple values allowed)
 --no-code-coverage-for-classes     Disable code coverage for classes <class> (multiple values allowed)
 --files                            (-f) Execute all unit test files <file> (multiple values allowed)
 --directories                      (-d) Execute unit test files in all <directory> (default: Array(    [0] => /var/www/ereservation/test/unit/)) (multiple values allowed)
 --test-file-extensions             Execute unit test files with one of extensions <extension> (multiple values allowed)
 --glob                             (-g) Execute unit test files which match <pattern> (multiple values allowed)
 --tags                             Execute only unit test with tags <tag> (multiple values allowed)
 --methods                          (-m) Execute all <class::method>, * may be used as wildcard for class name or method name (multiple values allowed)
 --namespaces                       Execute all classes in all namespaces <namespace> (multiple values allowed)
 --loop                             (-l) Execute tests in an infinite loop
 --test-it                          Execute atoum unit tests (multiple values allowed)
 --test-all                         Execute unit tests in directories defined via $script->addTestAllDirectory('path/to/directory') in a configuration file (multiple values allowed)
 --force-terminal                   Force output as in terminal (multiple values allowed)
 --bootstrap-file                   Include <file> before executing each test method (multiple values allowed)
 --use-light-report                 Use "light" CLI report (multiple values allowed)
 --debug                            Enable debug mode (multiple values allowed)

```

##Write tests

tests must include the bootstrap

``` php
require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';
```

##Atoum

Atoum repository and documentation are available here : 

https://github.com/atoum/atoum
