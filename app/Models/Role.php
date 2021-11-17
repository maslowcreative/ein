<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    const ROLE_ADMIN = 1;
    const ROLE_PROVIDER = 2;
    const ROLE_REPRESENTATIVE = 3;
    const ROLE_PARTICIPANT = 4;
    const ROLE_SUB_ADMIN = 5;
}
