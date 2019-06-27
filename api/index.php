<?php 
	namespace index;	
	require 'autoload.php';
	use Routes\api;
	
	$initRouteApi = new api;

	$initRouteApi->routes();

	