<?php
/**
 * Member object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseObject;
use Framework\Validation\Validation;
use Framework\Security\Authorisation;

class Member extends BaseObject {

	/**
	 * Custom data arrays
	 */
	private $customData = array();
	private $originalCustomData = array();
	
	/**
	 * Constructor. Call parent and then load custom data.
	 *
	 * @param array $data Object data
	 * @param array $customData Custom data
	 */
	function __construct ($data = array()) {
		parent::__construct($data);
		$this->fetchCustomData();
	}
	
	/**
	 * Fetch any custom data that is stored
	 */
	private function fetchCustomData () {
	
		if ($this->memberID) {
			$membersModel = new MembersModel();
			$this->customData = $this->originalCustomData = $membersModel->getCustomData($this->memberID);
		}
	
	}
	
	/**
	 * Get all custom data
	 *
	 * @return array Custom data
	 */
	public function getAllCustomData () {
		return $this->customData;
	}
	
	/**
	 * See if the data has changed
	 *
	 * @return boolean
	 */
	public function hasChanged () {
	
		if (parent::hasChanged()) {
		
			return true;
		
		} else {
		
			$arr = array_diff_assoc($this->customData, $this->originalCustomData);
			
			if (count($arr) > 0) {
				return true;
			} else {
				return false;
			}
		
		}
	
	}
	
	/**
	 * Set the member's address.
	 *
	 * @param string $value Address
	 * @return boolean Success
	 */
	public function setAddress ($value) {
		$this->setData("memberAddress", $value);
		return true;
	}
	
	/**
	 * Set the admin style
	 *
	 * @param int $value Style
	 * @return boolean Success
	 */
	public function setAdminStyle ($value) {
		$this->setData("memberAdminStyle", intval($value));
		return true;
	}
	
	/**
	 * Set a custom data field
	 *
	 * @param int $key Field ID
	 * @param string $value Value
	 * @return boolean Success
	 */
	public function setCustomData ($key, $value) {
	
		if ($key == "") {
			return false;
		} else {
			$this->customData[$key] = $value;
			return true;
		}
	
	}
	
	/**
	 * Set email address. It can be blank, but if it isn't, it must
	 * be a well formed email address.
	 *
	 * @param string $value Email address
	 * @return boolean Success
	 */
	public function setEmailAddress ($value) {
	
		if ($value != "") {
			if (Validation::validateEmail($value) === false) {
				$this->setMessage(LANG_INVALID." ".LANG_EMAIL_ADDRESS);
				return false;
			}
		}
		
		$this->setData("memberEmail", $value);
		return true;
	
	}
	
	/**
	 * Set the forename
	 *
	 * @param string $value Forename
	 * @return boolean Success
	 */
	public function setForename ($value) {
		$this->setData("memberForename", $value);
		return true;
	}
	
	/**
	 * Set the notes for this member
	 *
	 * @param string $value Notes
	 * @return boolean Success
	 */
	public function setNotes ($value) {
		$this->setData("memberNotes", $value);
		return true;
	}
	
	/**
	 * Set the password
	 *
	 * @param string $value Password
	 * @return boolean Success
	 */
	public function setPassword ($value) {
	
		if ($value != "") {
			$auth = Authorisation::getInstance();
			$pass = $auth->encodePassword($value);
			$this->setData("memberPassword", $pass);
		}
		
		return true;
	
	}
	
	/**
	 * Set the password reset key
	 *
	 * @param string $value Reset key
	 * @return boolean Success
	 */
	public function setPasswordResetKey ($value) {
	
		$this->setData("memberPasswordResetKey", $value);
		return true;
	
	}
	
	/**
	 * Set the privileges
	 *
	 * @param int $value Privilege level
	 * @return boolean Success
	 */
	public function setPrivileges ($value) {
		if (($value = intval($value)) !== 0) {
			$this->setData("memberPrivileges", $value);
			return true;
		} else {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_PRIVILEGES));
			return false;
		}
	}
	
	/**
	 * Set the surname
	 *
	 * @param string $value Surname
	 * @return boolean Success
	 */
	public function setSurname ($value) {
		$this->setData("memberSurname", $value);
		return true;
	}

}