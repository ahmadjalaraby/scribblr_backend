<?php

namespace App\Http\Controllers\Web;

use App\Actions\Tag\DeleteTagAction;
use App\Actions\Tag\UpsertTagAction;
use App\DataTransferObjects\TagData;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\Tag\EditTagViewModel;
use App\ViewModels\Tag\GetTagsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Tag/List', [
            'model' => new GetTagsViewModel(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Tag/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagData $data): RedirectResponse
    {
        UpsertTagAction::execute($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Tag $tag
     * @return Response
     */
    public function edit(Tag $tag): Response
    {
        return Inertia::render('Tag/Edit', [
            'tag' => new EditTagViewModel($tag),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(Request $request, Tag $tag): RedirectResponse
    {
        UpsertTagAction::execute(
            TagData::fromRequest($request),
        );
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        DeleteTagAction::execute($tag);
        return Redirect::route('tags.index');
    }
}
