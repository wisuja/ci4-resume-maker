<?php

namespace App\Controllers;

class Chat extends BaseController
{
    public function index()
    {
        if (!session()->get('token')) {
            return redirect()->to('/login');
        }
        echo ($this->session->get('token'));
        return view('chat');
    }
}