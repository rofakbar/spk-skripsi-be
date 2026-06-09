<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\QuestionnaireAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Get questionnaire data
     */
    public function index()
    {
        $alternatives = Alternative::select(
            'id',
            'kode',
            'nama_topik',
            'kompetensi_lulusan',
            'mata_kuliah_relevan',
            'deskripsi'
        )->get();

        $criteria = Criteria::where(
            'source',
            'user'
        )->select(
            'id',
            'kode',
            'nama',
            'tipe'
        )->get();

        return response()->json([
            'success' => true,
            'data' => [
                'alternatives' => $alternatives,
                'criteria' => $criteria
            ]
        ]);
    }

    /**
     * Submit questionnaire
     */
    public function submit(
        Request $request
    ) {

        $request->validate([

            'answers' =>
            'required|array',

            'answers.*.alternative_id' =>
            'required|exists:alternatives,id',

            'answers.*.criteria_id' =>
            'required|exists:criterias,id',

            'answers.*.nilai' =>
            'required|integer|min:1|max:5',
        ]);

        // wajib isi semua
        $expectedAnswers =
            Alternative::count()
            *
            Criteria::where(
                'source',
                'user'
            )->count();

        if (
            count(
                $request->answers
            )
            < $expectedAnswers
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                'Semua alternatif harus diisi lengkap'
            ], 422);
        }

        foreach (
            $request->answers
            as $answer
        ) {

            QuestionnaireAnswer::updateOrCreate(

                [
                    'user_id' =>
                    Auth::id(),

                    'alternative_id' =>
                    $answer['alternative_id'],

                    'criteria_id' =>
                    $answer['criteria_id']
                ],

                [
                    'nilai' =>
                    $answer['nilai']
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' =>
            'Questionnaire submitted successfully'
        ]);
    }
}
