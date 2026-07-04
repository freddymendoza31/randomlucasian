@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="container">
        <div class="row rowimg">
            <div class="col col-6 text-center">
                <x-random-lucasiano />
            </div>
            <div class="col col-6 text-center">
                <x-cuestionario-lucasiano />
            </div>
        </div>
    </div>
@endsection
