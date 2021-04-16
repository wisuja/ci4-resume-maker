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
        // cek login atau belum
        // if (!session()->get('token')) {
        //     return redirect()->to('/login');
        // }

        // buat token jwt
        $token = 'Bearer ' . $this->session->get('token');

        // buat header api
        $headers = [
            "Authorization: {$token}"
        ];

        // tangkap data dari ajax
        $username = $this->request->getVar('username');
        $message = $this->request->getVar('message');
        $createcv = ($this->request->getVar('createcv')) ? ($this->request->getVar('createcv')) : '';
        $parameter = ($this->request->getVar('parameter')) ? $this->request->getVar('parameter') : '';

        // prepare data request
        $request = [];
        if ($createcv && $parameter) {
            $request = [
                'username' => $username,
                'message' => $message,
                'createcv' => $createcv,
                'parameter' => $parameter
            ];
        } else {
            $request = [
                'username' => $username,
                'message' => $message,
            ];
        }

        // tampung response dari api
        $response = $this->postRequest("https://dumdumbros.com/chat", $request, $headers);

        // return $this->chatReply($response);
        return $this->chatReplyNH($response);
    }

    // for normal chat and help
    private function chatReplyNH($response)
    {
        // declare needs and accept response in string type
        $raw = json_decode($response, true);
        $message = $raw['message'];
        $details = '';

        // check response for specific formatting
        if ($raw['data']['commands']) {
            // for normal chat & help commands 
            foreach ($raw['data']['commands'] as $cmd) {
                $details .=  '<br><strong>' . $cmd['command'] . '</strong> ' . $cmd['description'];
            }
        } else if ($raw['data']['cvs']) {
            // for history commands
            foreach ($raw['data']['cvs'] as $d) {
                $details .= '';
            }
        }
        // finishing format
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        // return
        return $readyText;
    }

    // for create cv


}
