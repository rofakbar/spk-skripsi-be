<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'alternative_id',
        'criteria_id',
        'nilai'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function alternative()
    {
        return $this->belongsTo(
            Alternative::class
        );
    }

    public function criteria()
    {
        return $this->belongsTo(
            Criteria::class
        );
    }
}
