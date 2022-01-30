<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'language_codes',
        'phone_codes',
        'phone_number',
        'email',
        'message',
        'referances_id'
    ];

}

	
 