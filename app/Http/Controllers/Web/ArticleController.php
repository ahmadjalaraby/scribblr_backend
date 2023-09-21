<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\Web\Article\DeleteArticleAction;
use App\Actions\Web\Article\UpsertArticleAction;
use App\DataTransferObjects\ArticleData;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\Article\CreateArticleViewModel;
use App\ViewModels\Article\EditArticleViewModel;
use App\ViewModels\Article\GetArticlesViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Article/List', [
            'model' => new GetArticlesViewModel(new PaginateOptions()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Article/Create', [
            'model' => new CreateArticleViewModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        UpsertArticleAction::execute(
            data: ArticleData::fromRequest(request: $request)
        );
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): Response
    {
        return Inertia::render('Article/Edit', [
            'model' => new EditArticleViewModel(article: $article),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        UpsertArticleAction::execute(
            data: ArticleData::fromRequest(request: $request),
        );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        DeleteArticleAction::execute(article: $article);

        return Redirect::back();
    }
}
