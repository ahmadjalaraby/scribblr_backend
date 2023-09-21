<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Core\Query\Custom\ExtendedQueryParameters;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;
use LaravelJsonApi\Laravel\Routing\Relationships;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')
    ->get('/v1/user', function (Request $request) {

//        return response()->json(QueryParameters::cast(
//            $request
//        ));

//        return response()->json(ExtendedQueryParameters::cast($request)->toArray());


        return \LaravelJsonApi\Core\Responses\DataResponse::make($request->user())
            ->withQueryParameters(
                ExtendedQueryParameters::cast($request),
            )->withServer('v1');
    });

Route::post('/v1/login', LoginController::class)
    ->name('login');


JsonApiRoute::server('v1')
    ->middleware('auth:sanctum')
//    ->middleware('cache.api.response')
    ->prefix('v1')
    ->resources(function ($server) {

        $server->resource('articles', \App\Http\Controllers\Api\V1\ArticleController::class)
            ->relationships(function (Relationships $relationships) {
                $relationships->hasOne('image');
                $relationships->hasOne('user');
                $relationships->hasOne('tag');
                $relationships->hasMany('visits');
                $relationships->hasMany('comments');
            })->parameter('id');

        $server->resource('comments', JsonApiController::class)
            ->relationships(function (Relationships $relationships) {
                $relationships->hasMany('likes');
                $relationships->hasOne('user');
                $relationships->hasOne('article');
            })->parameter('id');

        $server->resource('tags', JsonApiController::class)
            ->relationships(function (Relationships $relationships) {
                $relationships->hasMany('articles');
            })->parameter('id');

        $server->resource('users', UsersController::class)
            ->relationships(function (Relationships $relationships) {
                $relationships->hasMany('articles');
                $relationships->hasMany('bookmarks');
                $relationships->hasMany('likes');
                $relationships->hasMany('followers');
                $relationships->hasMany('followedUsers');
            })->actions('-actions', function (ActionRegistrar $actions) {
                $actions->get('me', 'auth');
            })->parameter('id');


        $server->resource('follows', JsonApiController::class)
            ->parameter('id');

        $server->resource('countries', JsonApiController::class)
            ->parameter('id');

        $server->resource('galleries', JsonApiController::class)
            ->parameter('id');

        $server->resource('article-visits', JsonApiController::class)
            ->parameter('id');

        $server->resource('bookmarks', JsonApiController::class)
            ->parameter('id');

        $server->resource('likes', JsonApiController::class)
            ->parameter('id');
    });
