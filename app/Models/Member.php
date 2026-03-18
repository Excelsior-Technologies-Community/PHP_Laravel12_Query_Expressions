<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Specify table (optional, Laravel infers 'members' automatically)
    protected $table = 'members';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'role',
    ];
}