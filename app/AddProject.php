<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddProject extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */

    protected $table = 'add_projects';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'project_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_name', 'client_name'];

    public function projectDetail()
    {
        return $this->hasOne('App\ProjectDetail','project_id');
    }

    public function phaseTime()
    {
        return $this->hasMany('App\PhaseTime','project_id');
    }

    public function phaseIndividualResource()
    {
        return $this->hasMany('App\PhaseIndividualResource','project_id');
    }
}
