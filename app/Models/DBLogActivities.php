<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBLogActivities extends Model
{
    const CREATE = 'CREATE';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    const TABLE_NAME = 'log_aktivitas';
    const ACTION_COLUMN = 'action';
    const DESC_COLUMN = 'description';

    protected $table = DBLogActivities::TABLE_NAME;

    protected $fillable = [
        DBLogActivities::ACTION_COLUMN,
        DBLogActivities::DESC_COLUMN,
    ];
}
