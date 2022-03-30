<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeTeams extends Model
{
    use HasFactory;

    protected $table = 'college_teams';

    protected $fillable = [
        'name',
        'direction',
        'topic',
        'other_topic',
        'count_participants',
        'leader_fullname',
        'college',
        'other_college',
        'status'
    ];
}
