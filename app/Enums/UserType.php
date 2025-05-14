<?php

namespace App\Enums;

enum UserType: string
{
    case Student = 'S';
    case Professor = 'P';
    case Admin = 'A';
}
