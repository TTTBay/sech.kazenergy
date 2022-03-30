<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{

    use HasFactory;

    protected $table = 'participants';

    protected $fillable = [
        'fullname',
        'gender_id',
        'role_id',
        'team_id',
        'contest_id',
        'program',
        'curs',
        'faculty',
        'specialty',
        'confirmation_file',
        'age',
        'hash_link',
        'email',
        'phone',
        'status'
    ];



}
