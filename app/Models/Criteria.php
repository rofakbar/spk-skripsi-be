<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';

    protected $fillable = [
        'kode',
        'nama',
        'source',
        'bobot',
        'tipe',
        'deskripsi'
    ];

    public function alternativeScores()
    {
        return $this->hasMany(
            AlternativeCriteria::class
        );
    }

    public function questionnaireAnswers()
    {
        return $this->hasMany(
            QuestionnaireAnswer::class
        );
    }
}
