<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $fillable = [
        'kode',
        'nama_topik',
        'kompetensi_lulusan',
        'mata_kuliah_relevan',
        'deskripsi'
    ];

    public function criteria()
    {
        return $this->hasMany(
            AlternativeCriteria::class
        );
    }

    public function recommendationResults()
    {
        return $this->hasMany(
            RecommendationResult::class
        );
    }
}
