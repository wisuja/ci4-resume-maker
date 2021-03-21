<?php

namespace App\Models;

use CodeIgniter\Model;

class userModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'name', 'photo'];

    function getUserPassword($username, $password)
    {
        return $this->table('user')
            ->getWhere(['username' => $username, 'password' => $password])
            ->getRowArray();
    }

    function getUsername($username)
    {
        return $this->table('user')
            ->getWhere(['username' => $username])
            ->getRowArray();
    }
}