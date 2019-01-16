<?php /* Migration Commit */ ?><?php
Namespace Am\Config;

/**
 * This is a simple class that helps load project configuration contained 
 * in YAML files and/or arrays
 * 
 * Please check Readme and docs on how to effectively use the class.
 *
 * 
 * @package Am\Config
 * @version 1.0
 * @since 0.1
 * 
 * @todo Extend debugging support to other parts of the class.
 * @todo Add Serialization and Cache support
 * @todo Better error handling
 * 
 * @author Arvish K. Mungur <arvish.mungur@outlook.com>
 * @license https://github.com/arvish15/PHP-Configuration-Loader-Class MIT License
 * 
 */
Class Config{

	/**
	 * Contains value of the original argument $config passed if @see $debug is set to true. Else it defaults to null.
	 *  
	 * @var mixed|array|string
	 * @expected mixed|array|string -- Note: Is set only when $debug is set to true
	 * @default not set
	 * 
	 */
	public $config;

	
	/**
	 * Contains value of the original argument $src passed if @see $debug is set to true. Else it defaults to null.
	 * 
	 * @var int
	 * @expected 0 or 1 -- Note: Is set only when @see $debug is set to true
	 * @default not set
	 * 
	 */
	public $src;


	/**
	 * Set to true to enable debugging of class object via loaded parameters
	 * 
	 * @var boolean
	 * @default false
	 * 
	 */
	public $debug;


	/**
	 * Class Constructor creates the public variables from config file(s) and/or array(s) passed through $config parameter
	 * 
	 * @param mixed $config mixed|array|string
	 * @param int $src Default **0**. Optional. Accepted values are **0** or **1**.
	 * @param bool $debug Default **false**. Optional. Accepted values **true** or **false**.
	 * @return Config->load_config() Calls the <strong>load_config</strong> method Creates the public variables from config file(s) and/or array(s) passed through
	 * 
	 */
	public function __construct($config, $src = 0, $debug = false){

		return  $this->load_config($config, $src, $debug);

	}


	/**
	 * Creates the public variables from config file(s) and/or array(s) passed through
	 * $config parameter
	 * 
	 * @param mixed $config mixed|array|string
	 * @param int $src Default **0**. Optional. Accepted values are **0** or **1**.
	 * @param bool $debug Default **false**. Optional. Accepted values **true** or **false**.
	 * @return @see parse_configs() Creates the public variables from config file(s) and/or array(s) passed through
	 * 
	 */
	public function load_config($config, $src, $debug){

		if($debug){
			$this->config = $config;
			$this->src = $src;
		}
		
		$this->debug = $debug;

		if(is_int($src) && ($src == 1)){
			
			if(is_array($config)){
				foreach ($config as $config_obj) {
					$this->parse_configs($config_obj);
				}
			} else {

				$this->parse_configs($config);

			}

		} elseif(is_int($src) && ($src == 0)) {

			$this->parse_configs($config);

		} else {

			echo $this->errmsg("\$src can only be 1 or 0 (0 is the default argument)");
		
		}

	}

	/**
	 * Validates and parses settings contained in mixed|array|string $config
	 * @param  mixed $config mixed|array|string
	 * @return $vars Creates the public variables from config file(s) and/or array(s) passed through
	 * 
	 */
	protected function parse_configs($config){

		if(is_string($config) && file_exists($config)){

			if ($this->is_yaml_valid($config)) {
				$yaml_config = yaml_parse_file($config);

			    foreach($yaml_config as $key => $value) {
			    	$key = str_replace(' ', '_', $key);
			        $this->$key = $value;
			    }				
			} else {
				echo $this->errmsg("Config File: $config is invalid!");
			}

		} elseif ($this->is_assoc($config)) {

		    foreach($config as $key => $value) {
		    	$key = str_replace(' ', '_', $key);
		        $this->$key = $value;
		    }			

		}

	}


	/**
	 * Checks whether an array is an associative array.
	 * @param  array $a
	 * @return boolean returns true if array is associative.
	 * 
	 */
	protected function is_assoc( $a ) {
	    return is_array( $a ) && ( count( $a ) !== array_reduce( array_keys( $a ), create_function( '$a, $b', 'return ($b === $a ? $a + 1 : 0);' ), 0 ) );
	}

	/**
	 * Checks whether yaml within a file is valid.
	 * @param  string  $config yaml file name.
	 * @return boolean returns true if valid.
	 */
	protected function is_yaml_valid($config){
		
		$content = file_get_contents($config);
			
			set_error_handler(
				function($errno, $errstr){
					echo $this->errmsg($errstr);
				}, 
				E_WARNING
			);

			try{
				$parsed = yaml_parse($content);
			}catch(Exception $e){
				echo $this->errmsg($e->getMessage());
			}
			
			restore_error_handler();
			
			if ($parsed === FALSE){
				return false;
			}else{
				return true;
			}

	}


	/**
	 * Simple error notification
	 * @param  string $errstr
	 * @return string formats and displays error message in html format
	 */
	protected function errmsg($errstr){
		return nl2br("<div style='border:1px solid #EEE;background:#f9f6d6; padding:10px 10px 0px;margin:10px;font-family:sans-serif;'><h4 style='color:#E43137;margin:0px;'>Error:</h4><p>$errstr</p></div>");
	}

}