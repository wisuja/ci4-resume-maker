<?php

namespace App\Controllers;

class Chat extends BaseController
{
    protected $session = null;
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $username = $this->session->get('username');
        if ($username) {
            return view('chat');
        } else {
        }
    }
}