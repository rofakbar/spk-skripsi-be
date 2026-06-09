<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationSession extends Model
{
    protected $fillable = [
        'user_id',
        'top_alternative_id',
        'top_score'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function topAlternative()
    {
        return $this->belongsTo(
            Alternative::class,
            'top_alternative_id'
        );
    }

    public function results()
    {
        return $this->hasMany(
            RecommendationResult::class,
            'recommendation_session_id'
        );
    }
}
