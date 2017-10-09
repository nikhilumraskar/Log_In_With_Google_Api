<?php

class GoogleAuth
{
	protected $db;
	protected $client;

	public $user;
	
	function __construct(Google_Client $google_client = null, DB $db = null)
	{
		$this->db = $db;
		$this->client = $google_client;
		if($this->client){
			$this->client = $google_client;
			$this->client->setClientId(Config::CLIENT_ID);
			$this->client->setClientSecret(Config::CLIENT_SECRETE);
			$this->client->setRedirectUri('http://localhost/Projects/g_sign_in/index.php');
			$this->client->setScopes('email');
		}

	}

	public function isLoggedIn()
	{
		return isset($_SESSION['access_token']);
	}

	public function getAuthUrl()
	{
		return $this->client->createAuthUrl();
	}

	public function checkRedirectCode()
	{
		
		if(isset($_GET['code'])){

			$this->client->authenticate($_GET['code']);

			$this->set_token($this->client->getAccessToken());

			$this->client->verifyIdToken();
			//$this->storeUser($this->getPayload1());

			$this->storeUser($this->getPayLoad());

			return true;
		}
		return false;
	}

	public function set_token($token_arr)
	{

		$this->client->setAccessToken($token_arr);
		$_SESSION['access_token'] = $token_arr;

	}

	public function logout()
	{
		unset($_SESSION['access_token']);
	}


	protected function storeUser($payload)
	{
		$q = "INSERT INTO google_users
				SET google_id = '".$payload['sub']."',
				 email = '".$payload['email']."' ON DUPLICATE KEY UPDATE id = id";

		$this->db->query($q);
	}

	public function getPayLoad(){
	    $payLoad = $this->client->verifyIdToken();
	    return $payLoad;
	}

}