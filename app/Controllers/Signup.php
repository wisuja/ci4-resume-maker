<?php

namespace App\Controllers;

class Signup extends BaseController
{
    use CurlRequest;
    public function index()
    {
        $data = [
            'message' => $this->session->getFlashdata('message'),
            'validation' => \Config\Services::validation(),
        ];
        return view('signup', $data);
    }
    public function save()
    {
        $request = service('request');
        $name = $request->getPost('name');
        $username = $request->getPost('username');
        $password = $request->getPost('password');
        $password_confirmation = $request->getPost('password_confirmation');

        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi!',
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi!'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi!'
                ]
            ],
            'password_confirmation' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} harus di isi!'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput('validation', $validation);
            return redirect()->to('/signup')->withInput();
        }

        $url = "https://dumdumbros.com/register";
        $param = array(
            'name' => "$name",
            'username' => "$username",
            'password' => "$password",
            'password_confirmation' => "$password_confirmation",
        );
        $header = array();
        $signup = json_decode($this->postRequest($url, $param, $header));
        if ($signup->message == "User has been created successfully.") {
            $data = array(
                'token' => $signup->data->token,
                'username' => $signup->data->user->username,
            );
            $this->session->set($data);
            return redirect()->to('/chat');
        } else if ($signup->message == "The username has already been taken.") {
            $this->session->setFlashdata('message', $signup->message);
            return redirect()->to('/signup');
        }
        var_dump($signup);
        // return redirect()->to('/login')->withInput();
    }
}
