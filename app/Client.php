<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'client_id';
}
