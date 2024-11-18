<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userauth extends Model
{
    use HasFactory;

    protected $table = 'user_auth';
    protected $fillable = [
        'user_fullname',
        'user_email',
        'user_status',
        'password',
    ];
}
