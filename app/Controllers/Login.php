<?php

namespace App\Controllers;

class Login extends BaseController
{
	use CurlRequest;
	public function index()
	{
		return view('login');
	}

	public function cekLogin()
	{
		$session = \Config\Services::session();
		$request = service('request');
		$username = $request->getPost('username');
		$password = $request->getPost('password');

		// $url = "http://localhost:8000/login";
		$url = "http://william.dumdumbros.com/login";
		$param = array(
			'username' => "$username",
			'password' => "$password",
		);
		$header = array(
			// 'Content-Type' => 'application/json',

		);
		$tes = json_decode($this->postRequest($url, $param, $header));

		$data = array(
			'token' => $tes->data->token,
			'username' => $tes->data->user->username,
		);
		$session->set($data);

		return redirect()->to('/chat');
	}
}