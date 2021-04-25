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
        // LOGIN
        if (!session()->get('token')) {
            return redirect()->to('/login');
        }

        // CURLRequest - HEADER
        $headers = [
            "Authorization: Bearer {$this->session->get('token')}"
        ];

        // CURLRequest - BODY
        // POST PARAMETER
        $username = $this->request->getVar('username');
        $message = $this->request->getVar('message');

        switch ($message) {
            case '/history':
                $request = [
                    'username' => $username,
                    'message' => $message
                ];
                return $this->historyCommands($request, $headers);
                break;

            default:
                $request = [
                    'username' => $username,
                    'message' => $message
                ];
                return $this->helpCommands($request, $headers);
                break;
        }
    }

    // anonymous and help commands
    private function helpCommands($request, $headers)
    {
        $rawResponse = $this->postRequest("https://dumdumbros.com/chat", $request, $headers);
        $arrResponse = json_decode($rawResponse, true);
        $details = '';
        foreach ($arrResponse['data']['commands'] as $cmd) {
            $details .=  '<br><strong>' . $cmd['command'] . '</strong> ' . $cmd['description'];
        }
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$arrResponse['message']}{$details}" . "</div></div>";

        return $readyText;
    }

    // history commands
    private function historyCommands($request, $headers)
    {
        $rawResponse = $this->postRequest("https://dumdumbros.com/chat", $request, $headers);
        $arrResponse = json_decode($rawResponse, true);
        $message = $arrResponse['message'];
        $details = '';
        if ($arrResponse['data']['cvs'][0]['url_cv'] == null) { // true
            $message = "";
            $details = "Oops! you haven't created any cv";
        } else { // false
            foreach ($arrResponse['data']['cvs'] as $cv) {
                $urls = explode('|', $cv['url_recommendation']);
                $links = '';
                $i = 1;
                foreach ($urls as $u) {
                    $links .= "<a href='{$u}'>Link {$i}</a> |";
                    $i++;
                }
                $details .=  "<hr /> Download CV <a href='https://dumdumbros.com/cv/5'>here</a><br />Your job(s) recommendation:<br /> {$links}";
            }
        }
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        return $readyText;
    }
}
