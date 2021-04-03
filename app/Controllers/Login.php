<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
    }

    public function create()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        } else {
            $username = $this->request->getVar('username');
            // $password = $this->request->getVar('password');
            $hashed = $this->model->where('username', $username)->first();
            $password = password_verify($this->request->getVar('password'), $hashed['password']);
            $valUsername = $this->model->getUsername($username);

            if ($valUsername) {
                $user = $this->model->getUserPassword($username, $password);
                if ($user) {
                    $data = [
                        "status" => 200,
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'photo' => $user['photo'],
                    ];
                    return $this->respond($data, 200);
                } else {
                    return $this->failNotFound('Wrong password');
                }
            } else {
                return $this->failNotFound('Email not Found');
            }
        }
    }
}