<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config_file = array(
	dirname(__DIR__) . '/examples/configs/array.yaml'
);
$config_array = new \Am\Config\Config($config_file,1);

var_dump($config_array);

echo "<br/><br/><hr><br/><br/>";