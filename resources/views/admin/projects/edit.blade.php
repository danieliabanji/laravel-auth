@extends('layouts.admin')

@section('title', 'Aggiugni un nuovo progetto')

@section('content')
    <div class="container">
        <h2 class="mt-4 mb-4 text-center">Aggiorna {{ $project->title }}</h2>

        <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Inserisci il titolo del progetto</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('name', $project->title) }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Inserisci la descrizione</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content', $project->content) }} </textarea>

                @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="d-flex">
                <div class="media me-4">
                    <img class="shadow" width="150" src="{{ asset('storage/' . $project->cover_image) }}"
                        alt="{{ $project->title }}">
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Replace project image</label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="form-control  @error('cover_image') is-invalid @enderror">
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="type_id" class="form-label">Select Type</label>
                <select name="type_id" id="type_id" class="form-control @error('type_id') is-invalid @enderror">
                    <option value="">Select type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ $type->id == old('type_id') ? 'selected' : '' }}>
                            {{ $type->name }}</option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @foreach ($tags as $tag)
                <div class="form-check form-check-inline my-3">

                    @if (old('tags'))
                        <input type="checkbox" class="form-check-input" id="{{ $tag->slug }}" name="tags[]"
                            value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                    @else
                        <input type="checkbox" class="form-check-input" id="{{ $tag->slug }}" name="tags[]"
                            value="{{ $tag->id }}" {{ $project->tags->contains($tag) ? 'checked' : '' }}>
                    @endif
                    <label class="form-check-label" for="{{ $tag->slug }}">{{ $tag->name }}</label>
                </div>
            @endforeach
            @error('tags')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="my-5">
                <button type="submit" class="btn btn-success">Aggiungi</button>
                <button type="reset" class="btn btn-danger">Resetta</button>
            </div>
        </form>
    </div>
@endsection
