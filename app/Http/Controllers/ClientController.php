<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $clients = Client::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        Auth::user()->clients()->create($request->validated());

        return Redirect::to(route('clients.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->loadMissing(['projects']);

        return Inertia::render('Clients/Edit', [
            'client' => $client->refresh(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return Redirect::to(route('clients.show', [
            'client' => $client->id
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        Redirect::to(route('clients.index'));
    }
}
