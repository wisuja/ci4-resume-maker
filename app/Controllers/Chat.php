<?php

namespace App\Controllers;

class Chat extends BaseController
{
    use CurlRequest;
    private $endpoint = "https://dumdumbros.com/chat";

    public function index()
    {
        if (!session()->get('token')) {
            return redirect()->to('/login');
        }

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

        $request = [
            'username' => $username,
            'message' => $message
        ];

        switch ($message) {
            case '/history':
                return $this->historyCommands($request, $headers);
                break;
            default:
                return $this->helpCommands($request, $headers);
                break;
        }
    }

    // anonymous and help commands
    private function helpCommands($request, $headers)
    {
        [$message, $data] = $this->postRequestToChat($request, $headers);
        $details = '';
        foreach ($data['commands'] as $cmd) {
            $details .=  '<br><strong>' . $cmd['command'] . '</strong> ' . $cmd['description'];
        }
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        return $readyText;
    }

    // history commands
    private function historyCommands($request, $headers)
    {
        [$message, $data] = $this->postRequestToChat($request, $headers);

        $details = '';

        $cvs = $data["cvs"];
        $cvs = array_filter($cvs, fn ($cv) => $cv["url_cv"] !== null); // filter cv yang url_cv tidak null

        if (empty($cvs)) { // true
            $message = "";
            $details = "Oops! you haven't created any cv";
        } else { // false
            foreach ($cvs as $cv) {
                $urls = explode('|', $cv['url_recommendation']);
                $links = '';
                foreach ($urls as $index => $u) {
                    $links .= "<a href='{$u}'>Link ". ($index + 1) ." </a> |";
                }
                $details .=  "<hr /> Download CV <a href='{$cv["url_cv"]}'>here</a><br />Your job(s) recommendation:<br /> {$links}";
            }
        }
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        return $readyText;
    }

    private function postRequestToChat($request, $headers) {
        $response = json_decode($this->postRequest($this->endpoint, $request, $headers), true);

        return [$response["message"], $response["data"]];
    }
}
