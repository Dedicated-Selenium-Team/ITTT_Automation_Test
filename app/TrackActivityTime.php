<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackActivityTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'track_activity_time';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
