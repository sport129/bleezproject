<?php 
	namespace index;	
	require 'autoload.php';
	use Routes\api;

	header("Access-Control-Allow-Origin: *");
	
	$initRouteApi = new api;

	$initRouteApi->routes();

	