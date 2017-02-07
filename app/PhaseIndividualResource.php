<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhaseIndividualResource extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phase_individual_resources';

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
	protected $fillable = ['project_id', 'ph_id', 'd_id', 'spent_hrs','actual_hrs'];

	public function addProject() {
		return $this->belongsTo('App\AddProject', 'id');
	}
}
