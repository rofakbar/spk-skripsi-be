<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternativeCriteria extends Model
{
    protected $table = 'alternative_criteria';
    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'nilai'
    ];

    public function alternative()
    {
        return $this->belongsTo(
            Alternative::class
        );
    }

    public function criterion()
    {
        return $this->belongsTo(
            Criteria::class,
            'criteria_id'
        );
    }
}
