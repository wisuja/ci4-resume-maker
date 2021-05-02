<?php

namespace App\Controllers;

class Login extends BaseController
{
	use CurlRequest;
	public function index()
	{
		$data = [
			'message' => $this->session->getFlashdata('message'),
		];
		return view('login', $data);
	}

	public function cekLogin()
	{
		$request = service('request');
		$username = $request->getPost('username');
		$password = $request->getPost('password');

		$url = "http://localhost:8000/login";
		$param = array(
			'username' => "$username",
			'password' => "$password",
		);
		$header = array(
			// 'Content-Type' => 'multipart/form-data',
		);
		$login = json_decode($this->postRequest($url, $param, $header));
		if ($login->message == "User has logged in.") {

			$data = array(
				'token' => $login->data->token,
				'username' => $login->data->user->username,
				'createcv' => false,
				'parameter' => 'name'
			);
			$this->session->set($data);
			return redirect()->to('/chat');
		} else if ($login->message == "Wrong credentials.") {
			$this->session->setFlashdata('message', 'Wrong password');
			return redirect()->to('/login');
		} else if ($login->message == "User not found.") {
			$this->session->setFlashdata('message', 'User not found');
			return redirect()->to('/login');
		}
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to('/login');
	}
}
