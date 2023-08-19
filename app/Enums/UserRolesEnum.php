<?php 

namespace App\Enums;

enum UserRolesEnum : int {
    case USER = 1;
    case ADMIN = 2;
    case SUPER_ADMIN = 3;
}