<?php
namespace Am\Config;

/**
 * This is a simple class that helps load project configuration contained
 * in YAML files and/or arrays
 *
 * Please check Readme and docs on how to effectively use the class.
 *
 * @package Am\Config
 * @version 1.0
 * @since 0.1
 *
 * @todo Extend debugging support to other parts of the class.
 * @todo Add Serialization and Cache support
 * @todo Better error handling
 *
 * @author Vurghus Minar <vurghus.minar@outlook.com>
 * @license https://github.com/vurghus-minar/PHP-Configuration-Loader-Class MIT License
 */
class Config {

	/**
	 * Contains value of the original argument $config passed if @see $debug is set to true. Else it defaults to null.
	 *
	 * @var mixed|array|string
	 * @expected mixed|array|string -- Note: Is set only when $debug is set to true
	 * @default not set
	 */
	public $config;


	/**
	 * Contains value of the original argument $src passed if @see $debug is set to true. Else it defaults to null.
	 *
	 * @var int
	 * @expected 0 or 1 -- Note: Is set only when @see $debug is set to true
	 * @default not set
	 */
	public $src;


	/**
	 * Set to true to enable debugging of class object via loaded parameters
	 *
	 * @var boolean
	 * @default false
	 */
	public $debug;


	/**
	 * Class Constructor.
	 *
	 * @param mixed $config mixed|array|string Configuration yaml file(s) or arrays.
	 * @param int   $src Default **0**. Optional. Accepted values are **0** or **1**.
	 * @param bool  $debug Default **false**. Optional. Accepted values **true** or **false**.
	 * @return Config->load_config() Calls the <strong>load_config</strong> method Creates the public variables from config file(s) and/or array(s) passed through
	 */
	public function __construct( $config, int $src = 0, $debug = false ) {

		return $this->load_config( $config, $src, $debug );

	}


	/**
	 * Creates the public variables from config file(s) and/or array(s).
	 *
	 * @param mixed $config mixed|array|string Configuration yaml file(s) or arrays.
	 * @param int   $src Default **0**. Optional. Accepted values are **0** or **1**.
	 * @param bool  $debug Default **false**. Optional. Accepted values **true** or **false**.
	 */
	public function load_config( $config, $src, $debug ) {

		if ( $debug ) {
			$this->config = $config;
			$this->src    = $src;
		}

		$this->debug = $debug;

		if ( 1 === $src ) {

			if ( is_array( $config ) ) {
				foreach ( $config as $config_obj ) {
					$this->parse_configs( $config_obj );
				}
			} else {

				$this->parse_configs( $config );

			}
		}

		if ( 0 === $src ) {

			$this->parse_configs( $config );

		}

	}

	/**
	 * Validates and parses settings contained in mixed|array|string $config
	 *
	 * @param  mixed $config mixed|array|string Configuration yaml file(s) or arrays.
	 */
	protected function parse_configs( $config ) {

		if ( is_string( $config ) && file_exists( $config ) ) {

			$yaml_config = yaml_parse_file( $config );

			foreach ( $yaml_config as $key => $value ) {
				$key        = str_replace( ' ', '_', $key );
				$this->$key = $value;
			}
		} elseif ( $this->is_assoc( $config ) ) {

			foreach ( $config as $key => $value ) {
				$key        = str_replace( ' ', '_', $key );
				$this->$key = $value;
			}
		}

	}


	/**
	 * Checks whether an array is an associative array.
	 *
	 * @param  array $a The array to verify.
	 * @return boolean returns true if array is associative.
	 */
	protected function is_assoc( $a ) {
		return is_array( $a ) && ( count( $a ) !== array_reduce( array_keys( $a ), create_function( '$a, $b', 'return ($b === $a ? $a + 1 : 0);' ), 0 ) );
	}

}
