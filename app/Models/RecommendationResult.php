<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationResult
extends Model
{
    protected $fillable = [
        'recommendation_session_id',
        'user_id',
        'alternative_id',
        'rank',
        'score'
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
    public function session()
    {
        return $this->belongsTo(
            RecommendationSession::class,
            'recommendation_session_id'
        );
    }
}
