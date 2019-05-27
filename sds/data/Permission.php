<?php
/**
 * Created by PhpStorm.
 * User: jasper
 * Date: 5/25/19
 * Time: 9:20 AM
 */

class Permission {

	var $id;
	var $title;
	var $usergroup;
	var $description;

	/**
	 * Permission constructor.
	 * @param $id
	 * @param $title
	 * @param $usergroup
	 * @param $description
	 */
	public function __construct($id, $title, $usergroup, $description) {
		$this->id = $id;
		$this->title = $title;
		$this->usergroup = $usergroup;
		$this->description = $description;
	}


}