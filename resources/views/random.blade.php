@extends('layouts.RandomApp')
@section('title', 'Home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-12 text-center" id="centralizado">
                <h2 style="text-align: center;">Selector de participantes aleatorio Lucasian@s</h2>
                <button id="selectRandom">Random </button>
                <p id="selectedParticipant"></p>
                <audio id="drumroll" src="./"></audio>
            </div>
        </div>
    </div>
@endsection
