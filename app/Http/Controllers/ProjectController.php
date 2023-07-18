<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProjectRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->projects()->create([
            'name' => $data['name'],
            'user_id' => $request->user()->id
        ]);

        return Redirect::route('clients.show', ['client' => $client->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Client $client, Project $project)
    {
        $project->update($request->validated());

        return Redirect::to(route('clients.show', ['client' => $client->id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Client $client, Project $project)
    {
        abort_unless($request->user()->can('view', $client) && $request->user()->can('delete', $project), 403, 'You are not authorized to delete this project.');

        $project->delete();

        return Redirect::to(route('clients.show', ['client' => $client->id]));
    }
}
