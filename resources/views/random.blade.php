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
                <button type="button" id="openParticipantsCrudModal" class="btn btn-link participants-modal-trigger" title="CRUD de participantes">
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

    <div class="modal fade" id="participantsCrudModal" tabindex="-1" role="dialog" aria-labelledby="participantsCrudModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content participants-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantsCrudModalLabel">CRUD de participantes</h5>
                    <button type="button" class="close participants-modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="participantsCrudForm" class="participants-crud-form">
                        <input type="hidden" id="participantCrudId" name="id">
                        <div class="create-participant-panel is-collapsed">
                            <button type="button" class="crud-section-title" id="toggleCreateParticipantSection" aria-expanded="false" aria-controls="createParticipantBody">
                                <i class="fas fa-plus-circle"></i>
                                Crear participante
                                <i class="fas fa-chevron-right create-section-chevron"></i>
                            </button>
                            <div id="createParticipantBody" class="create-participant-body">
                                <p class="create-participant-hint">El nuevo participante siempre se guardará como activo.</p>
                                <div class="row create-participant-grid">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="participantCrudName">Nombres y apellidos</label>
                                            <input type="text" class="form-control" id="participantCrudName" name="nombres_apellidos" placeholder="Ingresa el nombre completo">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group participant-crud-buttons">
                                            <button type="submit" class="btn btn-success btn-block" id="saveParticipantBtn">
                                                <i class="fas fa-save"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="crud-toolbar">
                        <div class="form-group crud-search-group">
                            <label for="participantCrudSearch">Buscar participante</label>
                            <input type="text" class="form-control" id="participantCrudSearch" placeholder="Escribe para filtrar por nombre">
                        </div>
                        <button type="button" class="btn btn-default" id="crudCancelEdit">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                    </div>

                    <hr class="crud-separator">

                    <div class="table-responsive participants-table-wrapper">
                        <table class="table table-bordered table-striped participants-table">
                            <thead>
                                <tr>
                                    <th>Nombres y apellidos</th>
                                    <th>Fecha de actualizacion</th>
                                    <th>Estado</th>
                                    <th>Cambiar estado</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="participantsCrudModalBody">
                                <tr>
                                    <td colspan="5" class="text-center">Cargando participantes...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="participantsCrudModalMessage" class="participants-modal-message"></div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
