<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_details';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['designation_id', 'qualification', 'address', 'mobile_no', 'alternate_no', 'joining_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
