<?php

require_once 'app/init.php';


$auth = new GoogleAuth();

$auth->logout();

header('Location: index.php');