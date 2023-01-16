@extends('layouts.admin')

@section('content')
    <h1 class="text-center m-3">Types</h1>
    <div class="text-end mx-3">
        <a class="btn btn-success" href="{{ route('admin.types.create') }}"><i class="fa-solid fa-plus"></i></a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success mb-3 mt-3">
            {{ session()->get('message') }}
        </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col" class="col-9">Types</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <th scope="row">{{ $type->id }}</th>
                    <td>{{ $type->name }}</td>
                    <td class="px-4">{{ count($type->projects) }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.types.show', $type->slug) }}" class="btn btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.types.edit', $type->slug) }}" class="btn btn-secondary"
                            title="Edit type"><i class="fa-solid fa-pen"></i></a>

                        <form action="{{ route('admin.types.destroy', $type->slug) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"
                                data-item-title="{{ $type->name }}"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('partials.modal')
@endsection
