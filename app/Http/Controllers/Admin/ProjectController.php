<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.projects.index', ['projects' => Project::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $valData = $request->validated();

        $valData['slug'] = Str::slug($request->title, '-');

        if ($request->has('thumb')) {
            $file_path = Storage::put('thumbs', $request->thumb);
            $valData['thumb'] = $file_path;
        }

        $newProject = Project::create($valData);
        $newProject->technologies()->attach($request->technologies);

        return to_route('admin.projects.index')->with('status', 'Post created succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $valData = $request->validated();

        // INVOCA IL METODO DENTRO IL MODEL
        $valData['slug'] = $project->generateSlug($request->title);

        if ($request->has('thumb')) {

            // SALVA L'IMMAGINE NEL FILESYSTEM
            $newThumb = $request->thumb;
            $path = Storage::put('thumbs', $newThumb);

            // SE IL FUMETTO HA GIA' UNA COVER NEL DB  NEL FILE SYSTEM, DEVE ESSERE ELIMINATA DATO CHE LA STIAMO SOSTITUENDO
            if (!is_Null($project->thumb) && Storage::fileExists($project->thumb)) {
                // ELIMINA LA VECCHIA PREVIEW
                Storage::delete($project->thumb);
            }

            // ASSEGNA AL VALORE DI $valData IL PERCORSO DELL'IMMAGINE NELLO STORAGE
            $valData['thumb'] = $path;
        }

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies); 
        }

        // AGGIORNA L'ENTITA' CON I VALORI DI $valData
        $project->update($valData);
        return to_route('admin.projects.show', $project->slug)->with('status', 'Well Done, Element Edited Succeffully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        //dd($project->exif_thumbnail);
        //dd($project->thumb);
        if (!is_null($project->thumb)) {
            Storage::delete($project->thumb);
        }
        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Welldone! Project deleted successfully');
    }

    public function trash_projects()
    {
        return view('admin.projects.trash', ['trash_project' => Project::onlyTrashed()->orderByDesc('deleted_at')->paginate(5)]);
    }


    public function restore($id)
    {
        $project = Project::withTrashed()->find($id);
        $project->restore();

        return to_route('admin.projects.index')->with('message', 'Welldone! Project restored successfully');
    }

    public function forceDelete($id)
    {
        $project = Project::onlyTrashed()->find($id);

        if (!is_Null($project->thumb)) {
            Storage::delete($project->thumb);
        }

        $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.projects.trash')->with('status', 'Well Done, Element Deleted Succeffully');
    }
}
