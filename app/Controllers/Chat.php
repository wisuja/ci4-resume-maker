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
        // echo ($this->session->get('token'));

        $token = 'Bearer ' . $this->session->get('token');

        // echo $token;
        $headers = [
            "Authorization: {$token}"
            // 'Content-Type' => 'application/json'
        ];

        $response = $this->getRequest('https://dumdumbros.com/chat', $headers);

        var_dump($response);

        return view('chat');
    }
}