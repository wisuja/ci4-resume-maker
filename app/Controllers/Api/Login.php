<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
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
            $password = $this->request->getVar('password');

            $valUsername = $this->model->getUsername($username);
            if ($valUsername) {
                $hashed = $this->model->where('username', $username)->first();

                if (password_verify($password, $hashed['password'])) {
                    $row = $this->model->where('username', $username)->first();
                    $data = [
                        "status" => 200,
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'photo' => $row['photo'],
                    ];
                    return $this->respond($data, 200);
                } else {
                    return $this->failNotFound('Wrong password');
                }
            } else {
                return $this->failNotFound('Username not Found');
            }
        }
    }
}
