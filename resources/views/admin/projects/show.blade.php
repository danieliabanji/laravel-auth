@extends('layouts.admin')

@section('title', $project->title)

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-3">{{ $project->title }}</h2>
        <div class="d-flex justify-content-between">
            <small>Craeto il {{ $project->created_at }}</small>
            @if ($project->type)
                <small>Type: {{ $project->type->name }}</small>
            @endif
            <div class="controls">
                <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-secondary">
                    <i class="fa-solid fa-pencil"></i>
                </a>

                <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="show-delete-btn"
                        button-project-name="{{ $project->title }}"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
        <div>

            <p class="mt-4">{!! $project->content !!}</p>
        </div>

        <div class="my-3">
            <h5>Tags</h5>
            @if ($project->tags && count($project->tags) > 0)
                @foreach ($project->tags as $tag)
                    <span>{{ $tag->name }}</span>
                @endforeach
            @endif
        </div>

        <img src="{{ asset('storage/' . $project->cover_image) }}" class="my-3">
        @include('partials.modal')
    </div>
@endsection
