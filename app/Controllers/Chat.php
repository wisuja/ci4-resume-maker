<?php

namespace App\Controllers;

use App\Libraries\Careerjet_API;

class Chat extends BaseController
{
    use CurlRequest;

    private $endpoint = "http://localhost:8000/chat";

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

        if (session('createcv') == false) {
            $request = [
                'username' => $username,
                'message' => $message
            ];

            switch ($message) {
                case '/history':
                    return $this->historyCommands($request, $headers);
                    break;
                case "/createcv":
                    return $this->createCommands($request, $headers);
                    break;
                default:
                    return $this->helpCommands($request, $headers);
                    break;
            }
        } else {
            $request = [
                'username' => $username,
                'message' => $message,
                'parameter' => session('parameter'),
                'createcv' => true
            ];

            return $this->createCommands($request, $headers);
        }
    }

    private function postRequestToChat($request, $headers)
    {
        $response = json_decode($this->postRequest($this->endpoint, $request, $headers), true);

        return [$response["message"], $response["data"]];
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
        $cvs = array_filter($cvs, function ($cv) {
            return $cv["url_cv"] !== null;
        }); // filter cv yang url_cv tidak null

        if (empty($cvs)) { // true
            $message = "";
            $details = "Oops! you haven't created any cv";
        } else { // false
            foreach ($cvs as $cv) {
                $urls = explode('|', $cv['url_recommendation']);
                $links = '';
                foreach ($urls as $index => $u) {
                    $links .= "<a href='{$u}'>Link " . ($index + 1) . " </a> |";
                }
                $details .=  "<hr /> Download CV <a href='{$cv["url_cv"]}'>here</a><br />Your job(s) recommendation:<br /> {$links}";
            }
        }
        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        return $readyText;
    }

    // create cv commmands
    private function createCommands($request, $headers)
    {
        /*
            URUTAN:
            name, email, phone, address, keywords, skills, description, education, work_experiences, links
        */

        [$message, $data] = $this->postRequestToChat($request, $headers);
        $createcv = $data['createcv'];
        $parameter = $data['parameter'];
        $details = '';
        session()->set([
            'createcv' => $createcv,
            'parameter' => $parameter
        ]);

        switch ($parameter) {
                // name, email, phone, address, keywords, skills, description, education, work_experiences, links
            case 'name':
                $details = 'Please fill your name!';
                break;
            case 'email':
                $details = 'Please fill your active email with correct mail format (e.g. jobsfree@gmail.com)';
                break;
            case 'phone':
                $details = 'Please fill your active phone number with correct phone number format (e.g. 08136475768117)';
                break;
            case 'address':
                $details = 'Please let us know where do you live';
                break;
            case 'keywords':
                $details = 'What kind of jobs that you want us to recommend you? Let us know the keywords! Use | to separate each keyword! (e.g. PHP Developer|Web Designer)';
                break;
            case 'skills':
                $details = 'What kind of skill you acquire? Use | to separate each skill! (e.g. Javascript|PHP)';
                break;
            case 'description':
                $details = 'Tell us more about you, describe yourself!';
                break;
            case 'education':
                $details = 'How about your education? Use | to separate each education! (Format you must follow e.g. Information Systems, UIB, 2018-2022|IPA, SMA 1, 2015-2018)';
                break;
            case 'work_experiences':
                $details = 'Did you have any work experiences? Please let us know too! Use | to separate each work experiences (Format you must follow e.g. Software Engineer, Google, 2021|Tech Lead, Facebook, 2020)';
                break;
            case 'links':
                $details = 'Any links of your social media or your personal site? Please let us know! Use | to separate each work experiences (e.g. https://user.com|https://linkedin.com/in/user)';
                break;
            default:
                $details = '';
                break;
        }

        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}<br/>{$details}" . "</div></div>";

        return $readyText;
    }

    // untuk test code
    public function test()
    {
        $request = [
            'username' => 'asd',
            'message' => 'https://dangduck.github.io',
            'parameter' => 'links',
            'createcv' => true
        ];
        $headers = [
            "Authorization: Bearer {$this->session->get('token')}"
        ];

        [$message, $data] = $this->postRequestToChat($request, $headers);
        dd($this->postRequestToChat($request, $headers));
        $createcv = $data['createcv'];
        $parameter = $data['parameter'];
        $details = '';

        if ($createcv != null || $parameter != null) {
            session()->set([
                'createcv' => $createcv,
                'parameter' => $parameter
            ]);
        }

        switch ($parameter) {
                // name, email, phone, address, keywords, skills, description, education, work_experiences, links
            case 'name':
                $details = 'Please fill your name!';
                break;
            case 'email':
                $details = 'Please fill your active email with correct mail format (e.g. jobsfree@gmail.com)';
                break;
            case 'phone':
                $details = 'Please fill your active phone number with correct phone number format (e.g. 08136475768117)';
                break;
            case 'address':
                $details = 'Please let us know where do you live';
                break;
            case 'keywords':
                $details = 'What kind of jobs that you want us to recommend you? Let us know the keywords! Use | to separate each keyword! (e.g. PHP Developer|Web Designer)';
                break;
            case 'skills':
                $details = 'What kind of skill you acquire? Use | to separate each skill! (e.g. Javascript|PHP)';
                break;
            case 'description':
                $details = 'Tell us more about you, describe yourself!';
                break;
            case 'education':
                $details = 'How about your education? Use | to separate each education! (Format you must follow e.g. Information Systems, UIB, 2018-2022|IPA, SMA 1, 2015-2018)';
                break;
            case 'work_experiences':
                $details = 'Did you have any work experiences? Please let us know too! Use | to separate each work experiences (Format you must follow e.g. Software Engineer, Google, 2021|Tech Lead, Facebook, 2020)';
                break;
            case 'links':
                $details = 'Any links of your social media or your personal site? Please let us know! Use | to separate each work experiences (e.g. https://user.com|https://linkedin.com/in/user)';
                break;
            default:
                $details = '';
                break;
        }

        $readyText = "<div class='row mb-3 justify-content-start'> <div class='col reply'>{$message}{$details}" . "</div></div>";

        return $readyText;
    }
}
