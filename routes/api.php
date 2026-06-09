<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuestionnaireController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\Api\Admin\WeightController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ResultController;
use App\Http\Controllers\Api\Admin\HistoryController;
use App\Http\Controllers\Api\Admin\CriteriaController;
use App\Http\Controllers\Api\Admin\AlternativeController;
use App\Http\Controllers\Api\Admin\AlternativeCriteriaController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post(
        '/register',
        [AuthController::class, 'register']
    );

    Route::post(
        '/login',
        [AuthController::class, 'login']
    );

    Route::middleware(
        'auth:sanctum'
    )->group(function () {

        Route::get(
            '/profile',
            [AuthController::class, 'profile']
        );

        Route::post(
            '/logout',
            [AuthController::class, 'logout']
        );
    });
});

/*
|--------------------------------------------------------------------------
| USER API
|--------------------------------------------------------------------------
*/

Route::middleware(
    'auth:sanctum'
)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/me',
        [AuthController::class, 'me']
    );

    /*
    |--------------------------------------------------------------------------
    | Read Only Data
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/criteria',
        [CriteriaController::class, 'index']
    );

    Route::get(
        '/alternatives',
        [AlternativeController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Questionnaire
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/questionnaire',
        [
            QuestionnaireController::class,
            'index'
        ]
    );

    Route::post(
        '/questionnaire',
        [
            QuestionnaireController::class,
            'submit'
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | Recommendation
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/recommendation',
        [
            RecommendationController::class,
            'calculate'
        ]
    );

    Route::get(
        '/recommendation/latest',
        [
            RecommendationController::class,
            'latest'
        ]
    );

    Route::get(
        '/recommendation/detail',
        [
            RecommendationController::class,
            'detail'
        ]
    );

    Route::get(
        '/recommendation/history',
        [
            RecommendationController::class,
            'history'
        ]
    );

    Route::get(
        '/recommendation/history/{id}',
        [
            RecommendationController::class,
            'historyDetail'
        ]
    );
});

/*
|--------------------------------------------------------------------------
| ADMIN API
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware([
        'auth:sanctum',
        'role:admin'
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Test
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/test',
            function () {

                return response()->json([
                    'message' =>
                    'Admin only'
                ]);
            }
        );
        /*
|--------------------------------------------------------------------------
| Weights
|--------------------------------------------------------------------------
*/

        Route::get(
            '/weights',
            [WeightController::class, 'index']
        );

        Route::put(
            '/weights',
            [WeightController::class, 'update']
        );
        Route::get(
            '/criteria/total-weight',
            [CriteriaController::class, 'totalWeight']
        );

        /*
        |--------------------------------------------------------------------------
        | Dashboard Data
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/users',
            [
                UserController::class,
                'index'
            ]
        );

        Route::get(
            '/history',
            [
                HistoryController::class,
                'index'
            ]
        );

        Route::get(
            '/results',
            [
                ResultController::class,
                'index'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Criteria CRUD
        |--------------------------------------------------------------------------
        */

        Route::apiResource(
            'criteria',
            CriteriaController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Alternative CRUD
        |--------------------------------------------------------------------------
        */

        Route::apiResource(
            'alternatives',
            AlternativeController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Alternative Criteria CRUD
        |--------------------------------------------------------------------------
        */

        Route::apiResource(
            'alternative-criteria',
            AlternativeCriteriaController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Student Management
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/students',
            [
                StudentProfileController::class,
                'indexAdmin'
            ]
        );

        Route::post(
            '/students',
            [
                StudentProfileController::class,
                'storeAdmin'
            ]
        );

        Route::put(
            '/students/{id}',
            [
                StudentProfileController::class,
                'updateAdmin'
            ]
        );

        Route::delete(
            '/students/{id}',
            [
                StudentProfileController::class,
                'destroyAdmin'
            ]
        );
    });
