<?php

namespace App\Http\Controllers\Web;

use App\Actions\Country\DeleteCountryAction;
use App\Actions\Country\UpsertCountryAction;
use App\DataTransferObjects\CountryData;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\ViewModels\Country\EditCountryViewModel;
use App\ViewModels\Country\GetCountriesViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Country/List', [
            'model' => new GetCountriesViewModel(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Country/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryData $data): RedirectResponse
    {
        UpsertCountryAction::execute($data);
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
     */
    public function edit(Country $country): Response
    {
        return Inertia::render('Country/Edit', [
            'country' => new EditCountryViewModel($country),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country): RedirectResponse
    {
        UpsertCountryAction::execute(
            CountryData::fromRequest($request),
        );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country): RedirectResponse
    {
        DeleteCountryAction::execute($country);

        return Redirect::route('countries.index');
    }
}
