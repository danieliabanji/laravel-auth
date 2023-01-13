<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            $projects = Project::all();
        } else {
            $userId = Auth::id();
            $projects = Project::where('user_id', $userId)->get();
        }
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $userId = Auth::id();
        $form_data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $form_data['slug'] = $slug;
        $data['user_id'] = $userId;
        if($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $form_data['project_images'] = $path;
        }

        $new_project = Project::create($form_data);
        return redirect()->route('admin.projects.index', $new_project->slug)->with('message', "La creazione di $new_project->title è andata a buon fine!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }


        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $types = Type::all();
        return view('admin.projects.edit', compact('project','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $form_data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $form_data['slug'] = $slug;
        if($request->hasFile('cover_image')){
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $form_data['cover_image'] = $path;
        }
        $project->update($form_data);
        return redirect()->route('admin.projects.index')->with('message', "Hai aggiornato $project->title correttamente!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "$project->title è stato cancellato correttamente!");
    }
}
