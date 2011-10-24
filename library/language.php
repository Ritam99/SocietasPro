<?php
/**
 * Language module, adds multi-lingual support.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class Language {

	/**
	 * Variable to hold instance
	 */
	private static $instance;
	
	/**
	 * Variable to hold the language strings
	 */
	private static $strings = array();
	
	/**
	 * Prevent instancing
	 */
	private function __construct () {
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			self::load("en");
		}
		return self::$instance;
	}
	
	/**
	 * Get an array of language strings
	 *
	 * @return array Language strings
	 */
	public function getStrings () {
		return self::$strings;
	}
	
	/**
	 * Load a set of language strings
	 *
	 * @param string $languageCode Two character ISO code
	 */
	private static function load ($languageCode) {
	
		$languageFile = "languages/" . $languageCode . ".php";
		//if (!fileExists($languageCode)) { @todo Reimpment this check
		//	die("Language file not found."); // @todo Improve error handling
		//}
		
		include_once($languageFile);
		self::$strings = $language_strings;
	
	}

}