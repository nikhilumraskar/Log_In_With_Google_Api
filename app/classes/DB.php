<?php

class DB
{
	
	protected $mysqli;

	function __construct()
	{
		$this->mysqli = new mysqli('localhost','root','','g_sign_in_db');
	}

	public function query($q)
	{
		return $this->mysqli->query($q);
	}
}