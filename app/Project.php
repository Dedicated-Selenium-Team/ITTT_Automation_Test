<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'project_id';

    public function projectResources()
    {
        return $this->hasMany('App\ProjectResources','project_id');
    }
}
