<?php

namespace App\Model\Members;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DesignationMember extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designation_member';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function designations()
    {
        return $this->belongsTo(Designation::class);
    }

    public function members()
    {
        return $this->belongsTo(Member::class);
    }
}
