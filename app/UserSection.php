<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSection extends Model
{
    // protected $table = 'user_sections';
    protected $fillable = [
        'email', 'oc', 'country', 'level'
    ];
}
