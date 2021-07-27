@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Hello, {{ Auth::user()->name }}! You have {{ Auth::user()->projects->count() }} Projects to manage.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @livewire('projects')
</div>
@endsection
