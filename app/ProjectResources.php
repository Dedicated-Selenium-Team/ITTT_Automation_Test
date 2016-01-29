<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectResources extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_resources';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function project()
    {
        return $this->belongsTo('App\Project','project_id');
    }
}
