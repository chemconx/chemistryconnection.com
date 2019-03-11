<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 2/24/19
 * Time: 9:13 PM
 */

class DataSheet {
	/** @var string */
	var $name;

	var $fileType = 1;

	/** @var string */
	var $filepath;

	/** @var DateTime */
	var $dateUploaded;

	/** @var int */
	var $id;

	/**
	 * DataSheet constructor.
	 * @param string $name
	 * @param string $filepath
	 * @param DateTime $dateUploaded
	 * @param int $id
	 */
	public function __construct($name, $filepath, DateTime $dateUploaded, $id, $fileType = 1) {
		$this->name = $name;
		$this->filepath = $filepath;
		$this->dateUploaded = $dateUploaded;
		$this->id = $id;
		$this->fileType = $fileType;
	}


}