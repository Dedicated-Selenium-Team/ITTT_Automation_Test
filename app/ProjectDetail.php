<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'project_details';

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
  protected $fillable = ['start_date', 'p_I_live', 'expected_resources','warranty_days','holidays'];

  public function addProject()
  {
      return $this->belongsTo('App\AddProject','id');
  }

}
