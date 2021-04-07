<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Register extends ResourceController
{
    protected $modelName = 'App\Models\userModel';
    protected $format = 'json';

    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
    }

    //Mendaftar userbaru
    //http://localhost:8080/register
    //method: POST
    public function create()
    {
        helper(['form']);

        $rules = [
            'username' => [
                'rules' => 'required|is_unique[user.username,id,{id}]',
                'errors' => [
                    'is_unique' => '{field} telah digunakan'
                ]
            ],
            'password' => 'required',
            'name' => 'required',
            'photo' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        } else {
            $pass = $this->request->getVar('password');
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => $hash,
                'name' => $this->request->getVar('name'),
                'photo' => $this->request->getVar('photo'),
                // 'creates_on' => date("Y-m-d H:i:s"),
            ];
            $insert = $this->model->insert($data);
            $data['id'] = $insert;
            $data['status'] = 200;
            return $this->respondCreated($data);
        }
    }
}
