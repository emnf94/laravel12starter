<?php

namespace App;

enum UserRole: string
{
    case user = 'user';
    case admin = 'admin';
}
