<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityTeams extends Model
{
    use HasFactory;

    protected $table = 'university_teams';

    protected $fillable = [
        'name',
        'direction',
        'topic',
        'other_topic',
        'count_participants',
        'leader_fullname',
        'mentor_fullname',
        'university',
        'other_university',
        'status'
    ];

}
