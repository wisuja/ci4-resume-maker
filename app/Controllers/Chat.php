<?php

namespace App\Controllers;

class Chat extends BaseController
{
    use CurlRequest;

    public function index()
    {
        if (!session()->get('token')) {
            return redirect()->to('/login');
        }

        $token = 'Bearer ' . $this->session->get('token');

        $headers = [
            "Authorization: {$token}"
        ];

        return view('chat');
    }

    public function chat()
    {
        $request = [
            'username' => $this->request->getVar('username'),
            'message' => $this->request->getVar('message'),
        ];

        if (!session()->get('token')) {
            return redirect()->to('/login');
        }

        $token = 'Bearer ' . $this->session->get('token');

        $headers = [
            "Authorization: {$token}"
        ];

        return $this->postRequest("https://dumdumbros.com/chat", $request, $headers);
    }
}
