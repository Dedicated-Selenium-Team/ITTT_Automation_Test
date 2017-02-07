<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'designation';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'designation_id';
}
