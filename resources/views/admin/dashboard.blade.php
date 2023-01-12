@extends('layouts.admin')

@section('title', 'dashboard')

@section('content')
    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6>Dashboard of{{ Auth::user()->name }}</h6>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p> Welcome {{ Auth::user()->name }}! You are logged in!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
