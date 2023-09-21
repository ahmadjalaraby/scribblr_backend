<?php

namespace App\Http\Controllers\Web;

use App\Actions\Web\User\DeleteUserAction;
use App\Actions\Web\User\UpsertUserAction;
use App\DataTransferObjects\UserData;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\User\CreateUserViewModel;
use App\ViewModels\User\EditUserViewModel;
use App\ViewModels\User\GetUsersViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('User/List', [
            'model' => new GetUsersViewModel(
                paginateOptions: new PaginateOptions()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('User/Create', [
            'model' => new CreateUserViewModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        UpsertUserAction::execute(
            data: UserData::fromRequest(request: $request),
        );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('User/Edit', [
            'user' => new EditUserViewModel($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        UpsertUserAction::execute(
            data: UserData::fromRequest(request: $request),
        );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        DeleteUserAction::execute($user);
        return Redirect::route('users.index');
    }
}
