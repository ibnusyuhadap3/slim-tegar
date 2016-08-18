<?php
namespace App\Controllers;

class ContohController
{
	public function index($response)
	{
		$response->write("Controller example");
		return $response;
	}
}