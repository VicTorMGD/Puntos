<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'email', 'password', 'role', 'avatar', 'phone', 'session_token'];
    protected $useTimestamps = true;

    protected $returnType = 'array';
}
