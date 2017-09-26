# PHP Configuration Loader Class

## About

The PHP configuration loader class helps the management and loading of application configuration through arrays or Yaml configuration files.

## Installation

Via Composer:

```shell
composer require am/config
```

Or simply download the code and add to your project.

## Example Use

config.yaml
```yml
root_path: C:/xampp/htdocs
base_url: /
directories:
  controllers: controllers
  models: models
  views: views
  core: core
test_number: 10
```

config-2.yaml
```yml
this name: config 2
this number: 10
test_number: 10
```

```php
<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config_mixed_src = array(
	dirname(__DIR__) . '/examples/configs/config.yaml',
	dirname(__DIR__) . '/examples/configs/config-2.yaml',
	array(
		'hotel'=>'5 star',
		'rooms'=> 10
	)
);
$config = new \Am\Config\Config($config_mixed_src,1,true);

var_dump($config);

```

Resulting dump:
```php
<?php
object(Am\Config\Config)[2]
  public 'config' => 
    array (size=3)
      0 => string 'C:\xampp\htdocs\projects\composer\config/examples/configs/config.yaml' (length=69)
      1 => string 'C:\xampp\htdocs\projects\composer\config/examples/configs/config-2.yaml' (length=71)
      2 => 
        array (size=2)
          'hotel' => string '5 star' (length=6)
          'rooms' => int 10
  public 'src' => int 1
  public 'debug' => boolean true
  public 'root_path' => string 'C:/xampp/htdocs' (length=15)
  public 'base_url' => string '/' (length=1)
  public 'directories' => 
    array (size=4)
      'controllers' => string 'controllers' (length=11)
      'models' => string 'models' (length=6)
      'views' => string 'views' (length=5)
      'core' => string 'core' (length=4)
  public 'test_number' => int 10
  public 'this_name' => string 'config 2' (length=8)
  public 'this_number' => int 10
  public 'hotel' => string '5 star' (length=6)
  public 'rooms' => int 10
```

You can now retrieve application configuration within your file as public vars as follows:

```php

echo $config->hotel; //returns "5 star"

foreach($config->directories as $dir){
	echo $dir;
}

```

## Additional Resources

### How to Install LibYAML

To allow PHP to parse YAML files, you will require php libyaml available.

https://github.com/LegendOfMCPE/LoM-CMS/wiki/How-to-Install-LibYAML

https://stackoverflow.com/questions/27122701/installing-php-yaml-extension-with-xampp-on-windows

Note for Windows Xampp users, it is useful to copy yaml.dll to your xampp php folder as well to allow it to run in CLI (important mainly while running tests).