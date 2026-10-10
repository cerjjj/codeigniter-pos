<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'full_name', 'password', 'avatar', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType = 'array';
}
