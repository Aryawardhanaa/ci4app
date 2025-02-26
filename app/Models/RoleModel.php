<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class RoleModel extends Model
{
    protected $table      = 'role';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_role',
        'is_deleted',
        'idt',
        'udt'
    ];
    public const ROLE_STAFF = 'Staff';
    public const ROLE_SUPERVISOR = 'Supervisor';
    public const ROLE_MANAGER = 'Manager';
}
