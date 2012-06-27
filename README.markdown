# *sfAtoumPlugin*

##Install

### Using composer

Add this to you dependancies in your composer.json ([example](https://gist.github.com/3006430)) : 

```
  "require"     : {
    "atoum/sfAtoumPlugin": "*"
  },
```

Afer a 

`php composer.phar update`

The plugin should be in the plugin folder and atoum in the vendor folder.

Then in your ProjectConfiguration file you have to activate the plugin and define the atoum path.

``` php
  sfConfig::set('sf_atoum_path', dirname(__FILE__) . '/../vendor/mageekguy/atoum');

  if (sfConfig::get('sf_environment') != 'prod')
  {
    $this->enablePlugins('sfAtoumPlugin');
  }
```


### Using a git submodule

Install atoum as a submodule

`git submodule add git://github.com/mageekguy/atoum.git lib/vendor/atoum`


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

You can pass a configuration file (see here for how to write the configuration file : https://github.com/mageekguy/atoum/wiki/atoum-et-Jenkins-(ou-Hudson) )
via the -c option :

`php symfony atoum:test -c config/atoum/hudson.php`



All atoum options are available :

```
 ./symfony help atoum:test
Usage:
 symfony atoum:test [-c|--configuration-file[="..."]] [-p|--php[="..."]] [-d|--default-report-title[="..."]] [-s|--score-file[="..."]] [-m|--max-children-number[="..."]] [-n|--no-code-coverage] [--test-it] [test-file-or-dir1] ... [test-file-or-dirN]

Arguments:
 test-file-or-dir        path to test files or folders

Options:
 --configuration-file    (-c) config file
 --php                   (-p) path to php binary
 --default-report-title  (-d) Define default report title
 --score-file            (-s) Save score in <file>
 --max-children-number   (-m) Maximum number of sub-processus which will be run simultaneously
 --no-code-coverage      (-n) disable code coverage
 --test-it               execute all atoum unit tests

```

##Write tests

tests must include the bootstrap

``` php
require_once __DIR__ . '/../../../../plugins/sfAtoumPlugin/bootstrap/unit.php';
```

##Atoum

Atoum repository and documentation are available here : 

https://github.com/mageekguy/atoum
