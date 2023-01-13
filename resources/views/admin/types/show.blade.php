@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-3">{{ $type->name }}</h2>
        <div class="d-flex justify-content-between">
            <small>Craeto il {{ $type->created_at }}</small>
            <div class="controls">
                <a href="{{ route('admin.types.edit', $type->slug) }}" class="btn btn-secondary">
                    <i class="fa-solid fa-pencil"></i>
                </a>

                <form action="{{ route('admin.types.destroy', $type->slug) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="show-delete-btn"
                        button-type-name="{{ $type->title }}"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
        <ul>
            @foreach ($type->projects as $project)
                <li>{{ $project->title }}</li>
            @endforeach
        </ul>
        @include('partials.modal')
    </div>
@endsection
