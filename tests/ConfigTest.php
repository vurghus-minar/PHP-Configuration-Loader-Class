<?php

use \PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase {

	/**
	 * @dataProvider configFilePath
	 * */
    public function testIfConfigFileExistsFileNameIsString($config_file)
    {

        $debug = true;
        $src = 0;

    	$config = New \Am\Config\Config($config_file, $src, $debug);
        $this->assertInstanceOf('Am\Config\Config', $config);
    	$this->assertTrue(is_string($config->config));
        $this->assertFileExists($config->config);
        
    }



    public function testIfConfigArrayIsAnAcceptableArgument()
    {

		$config_array = array(
			'root_path' => $_SERVER['DOCUMENT_ROOT'],
			'base_url' => '/',
			'directories' => array(
				'controllers' => 'controllers',
				'models' => 'models',
				'views' => 'views',
				'core' => 'core'		
			),
			'debug' => true
		);

    	$config = New \Am\Config\Config($config_array);
        $this->assertInstanceOf('Am\Config\Config', $config);
        $is_assoc_method = $this->invokeMethod($config,'is_assoc', array($config_array));
    	$this->assertTrue($is_assoc_method);

    }

    /**
     * @dataProvider simpleConfigArray
     * */
    public function testMultipleConfigSources($config_array){

        $configMultipleConfigSources = New \Am\Config\Config($config_array, 1, true);
        $this->assertInstanceOf('Am\Config\Config', $configMultipleConfigSources);
        $this->assertTrue($configMultipleConfigSources->debug);
        $this->assertEquals($configMultipleConfigSources->config, $config_array);

    }


    /**
     * @dataProvider configArray
     * */
    public function testLoadMultipleConfigSources($config_array){
        $config = New \Am\Config\Config($config_array, 1, true);
        $is_assoc_method = $this->invokeMethod($config,'parse_configs', array($config_array));
        $this->assertTrue($config->debug);
        $this->assertEquals(10, $config->test_number);

    }


    /**
     * @dataProvider configArray
     * */
    public function testIsArrayConfig($config_array){

        $src = 1;

        $config = New \Am\Config\Config($config_array, $src, true);

        $this->assertEquals($config->test_number, 10);

    }


    public function configFilePath(){
        return array(
            array(dirname(__DIR__) . '/examples/configs/config-2.yaml')
        );
    }


    public function configArray(){

        return array(
            array(
                dirname(__DIR__) . '/examples/configs/config.yaml',
                array(
                    'root_path' => $_SERVER['DOCUMENT_ROOT'],
                    'base_url' => '/',
                    'directories' => array(
                        'controllers' => 'controllers',
                        'models' => 'models',
                        'views' => 'views',
                        'core' => 'core'        
                    ),
                    'debug' => true,
                    'test_number' => 10
                ),
                dirname(__DIR__) . '/examples/configs/config-2.yaml',
                array(
                    'test' => 1,
                    'test2' => true,
                    'test3' => 0.02,
                    1 => 4,
                    'test_number' => 10
                )
            )
        );
        
    }


    public function simpleConfigArray(){

        return array(
            array(
                array(
                    'test_number1' => 10,
                    'test1' => 'bla'
                ),
                array(
                    'hotel1'=>'5 star',
                    'rooms1'=> 10
                )
            )
        );
        
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public static function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}