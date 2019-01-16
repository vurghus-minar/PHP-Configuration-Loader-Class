<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config = array(
'test_number' => 10, 'test' => 'bla'
);

$config_from_array = new \Am\Config\Config($config, 0, false);
echo $config_from_array->debug;
var_dump($config_from_array);

echo "<br/><br/><hr><br/><br/>";



$config_file = array(
	dirname(__DIR__) . '/examples/configs/config.yaml',
	dirname(__DIR__) . '/examples/configs/config-2.yaml',
	array(
		'hotel'=>'5 star',
		'rooms'=> 10
	)
);
$config_from_file = new \Am\Config\Config($config_file,1,true);

var_dump($config_from_file);

echo "<br/><br/><hr><br/><br/>";



$config_file_with_error = dirname(__DIR__) . '/examples/configs/config-contains-mistakes.yaml';
$config_from_file_with_error = new \Am\Config\Config($config_file_with_error,0,true);

var_dump($config_from_file_with_error);

echo "<br/><br/><hr><br/><br/>";



$config_arrays_only = array(
	array(
		'test_number1' => 10,
		'test1' => 'bla'
	),
	array(
		'hotel1'=>'5 star',
		'rooms1'=> 10
	)
);

$config_from__arrays_only = new \Am\Config\Config($config_arrays_only, 1, false);
echo $config_from__arrays_only->debug;
var_dump($config_from__arrays_only);

