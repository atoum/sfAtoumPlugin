# *sfAtoumPlugin*

##Install

Install sfAtoumPlugin as a git submodule

`git submodule add git://github.com/agallou/sfAtoumPlugin.git plugins/sfAtoumPlugin`

Get atoum bundle with the plugin

`cd plugins/sfAtoumPlugin && git submodule update --init && cd ../../`


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


##Atoum

Atoum repository and documentation is available here : 

https://github.com/mageekguy/atoum
