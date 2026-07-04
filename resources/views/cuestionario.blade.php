@extends('layouts.RandomApp')
@section('title', 'Home')
@section('content')
    <div class="container">
         <div class="row icono">
            <div class="col m-12" style=" text-align: end;">
                <i class="fa fa-user" style="color: #d2723b;font-size: 30px;"></i>
                <storage id="" style="color: #d2723b;font-size: 20px;"></storage>
            </div>
        </div>
        <div class="row">
            <div class="col col-12 " >
                <div class="content">
                     <h2 class="content">Cuestionario Lucasian@</h2>
                     <button id="selectCuest">cuestionario </button>
                     <p id="selectedParticipant" class="content"></p>
                     <audio id="drumroll" src="{{ asset('sounds/sonidoredobles.mp3') }}"></audio>
                </div>
            </div>
        </div>
    </div>
@endsection
