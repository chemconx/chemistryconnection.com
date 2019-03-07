<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/24/19
 * Time: 9:13 PM
 */

class SafetyDataSheet {
	/** @var string */
	var $name;

	/** @var string */
	var $filepath;

	/** @var DateTime */
	var $dateUploaded;

	/** @var int */
	var $id;

	/**
	 * SafetyDataSheet constructor.
	 * @param string $name
	 * @param string $filepath
	 * @param DateTime $dateUploaded
	 * @param int $id
	 */
	public function __construct($name, $filepath, DateTime $dateUploaded, $id) {
		$this->name = $name;
		$this->filepath = $filepath;
		$this->dateUploaded = $dateUploaded;
		$this->id = $id;
	}


}