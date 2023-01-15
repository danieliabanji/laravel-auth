<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\Tag;
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
        if (Auth::user()->isAdmin()) {
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
        $tags = Tag::all();
        return view('admin.projects.create', compact('types', 'tags'));
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
        $form_data['user_id'] = $userId;
        if ($request->hasFile('cover_image')) {
            $path = Storage::put('project_images', $request->cover_image);
            $form_data['project_images'] = $path;
        }

        $new_project = Project::create($form_data);

        if ($request->has('tags')) {
            $new_project->tags()->attach($request->tags);
        }

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
        if (!Auth::user()->isAdmin() && $project->user_id !== Auth::id()) {
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
        if (!Auth::user()->isAdmin() && $project->user_id !== Auth::id()) {
            abort(403);
        }
        $types = Type::all();
        $tags = Tag::all();
        return view('admin.projects.edit', compact('project', 'types', 'tags'));
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
        if (!Auth::user()->isAdmin() && $project->user_id !== Auth::id()) {
            abort(403);
        }
        $form_data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $form_data['slug'] = $slug;
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::put('project_images', $request->cover_image);
            $form_data['cover_image'] = $path;
        }
        $project->update($form_data);

        if ($request->has('tags')) {
            $project->tags()->sync($request->tags);
        } else {
            $project->tags()->sync([]);
        }

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
        if (!Auth::user()->isAdmin() && $project->user_id !== Auth::id()) {
            abort(403);
        }
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "$project->title è stato cancellato correttamente!");
    }
}
