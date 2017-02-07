<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanPhaseResource extends Model {
	//
	protected $fillable = ['project_id', 'ph_id', 'd_id', 'spent_hrs','actual_hrs'];
}
