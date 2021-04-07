<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		return view('user/index');
	}
	public function auth()
	{
		$username = $this->request->getVar('username');
		$password = $this->request->getVar('password');

		redirect()->to('/Api/login');
	}
}
