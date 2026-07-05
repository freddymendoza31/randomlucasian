@extends('layouts.RandomApp')
@section('title', 'Home')
@section('content')
    <div class="container">
         <div class="row icono">
            <div class="col m-12 random-actions">
                <div class="user-box">
                    <i class="fa fa-user" style="color: #d2723b;font-size: 30px;"></i>
                    <span id="user" style="color: #d2723b;font-size: 20px;"></span>
                </div>
                <button type="button" id="openParticipantsModal" class="btn btn-link participants-modal-trigger">
                    <i class="fas fa-user-cog"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col col-12 " >
                <div class="random-shell">
                    <div class="random-hero">
                        <div class="random-kicker">
                            <i class="fas fa-random"></i>
                            Sorteo activo
                        </div>
                        <h2 class="random-title">Selector de participantes aleatorio Lucasian@s</h2>
                        <p class="random-subtitle">Selecciona un participante al azar y administra el estado desde la misma pantalla.</p>
                    </div>
                    <div class="random-stage">
                     <button id="selectRandom">Random </button>
                     <p id="selectedParticipant" class="content random-result"></p>
                    <audio id="drumroll" src="./"></audio>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="participantsStatusModal" tabindex="-1" role="dialog" aria-labelledby="participantsStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content participants-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantsStatusModalLabel">Actualizar participantes</h5>
                    <button type="button" class="close participants-modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive participants-table-wrapper">
                        <table class="table table-bordered table-striped participants-table">
                            <thead>
                                <tr>
                                    <th>Nombres y apellidos</th>
                                    <th>Fecha de actualizacion</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="participantsModalBody">
                                <tr>
                                    <td colspan="4" class="text-center">Cargando participantes...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="participantsModalMessage" class="participants-modal-message"></div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
