@extends('layouts.admin')

@section('title', 'Tutti i progetti')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center  mb-3">Tutti i progetti</h2>
        <div class="control text-end  mb-3">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Data di creazione</th>
                    <th scope="col">Type</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->title }}</th>
                        <td>{{ $project->created_at }}</td>
                        <td>{{ $project->type ? $project->type->name : 'Senza tipo' }}</td>
                        <td>{{ $project->tags && count($project->tags) > 0 ? count($project->tags) : 0 }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-success">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-secondary">
                                <i class="fa-solid fa-pencil"></i>
                            </a>

                            <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn"
                                    button-project-name="{{ $project->title }}"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('partials.modal')
    </div>
@endsection
