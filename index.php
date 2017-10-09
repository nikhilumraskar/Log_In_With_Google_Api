<?php

require_once 'app/init.php';

$google_client = new Google_Client();
$db = new DB();

$auth = new GoogleAuth($google_client, $db);

if($auth->checkRedirectCode()){
	header('Location:index.php');
}

if(!$auth->isLoggedIn()){
	echo "<a href='".$auth->getAuthUrl()."'>login</a>";
}
else{
	echo "Hi <a href='logout.php'>logout</a>";
}