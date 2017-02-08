<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhaseTime extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'phase_times';

  /**
   * The primary key of the table.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['project_id', 'ph_id', 'spent_days'];

  public function addProject()
  {
      return $this->belongsTo('App\AddProject','id');
  }
}
