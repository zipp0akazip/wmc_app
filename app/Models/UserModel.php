<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserModel extends Generated\UserBaseModel
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;
}
