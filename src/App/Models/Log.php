<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'cid_reputation_log';

    protected $fillable = [
        'action',
        'phone',
        'flagged_service',
        'description',
        'callgroup',
    ];
}
