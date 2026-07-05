/*
Author: FREDDY JR MENDOZA PADILLA
Date: 21/06/2024
Description: Script para seleccionar un participante al azar, disparar confeti y administrar estados.
*/

$(document).ready(function () {
    countuser();
    bindParticipantsModal();

    // Evento al hacer clic en el boton
    $('#selectRandom').click(function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "get",
            url: "/randomuser",
            dataType: "json",
        }).done(function (data) {
            $('#selectedParticipant').html("<strong id='str'>Participante Seleccionado Es:</strong> " + "<strong id='str2'>" + data.nombres_apellidos + "</strong>");
            countuser();
        }).fail(function () {
            console.log('error');
        });

        confetti({
            particleCount: 1000,
            spread: 400,
            origin: { y: 0.3 }
        });
    });
});

function bindParticipantsModal() {
    $('#openParticipantsModal').on('click', function (e) {
        e.preventDefault();
        loadParticipants();
        $('#participantsStatusModal').modal('show');
    });

    $(document).on('change', '.participant-toggle', function () {
        let $toggle = $(this);
        let $row = $toggle.closest('tr');
        let participantId = $toggle.data('id');
        let nextStatus = $toggle.is(':checked') ? 2 : 1;

        updateParticipantStatus(participantId, nextStatus, $row, $toggle);
    });
}

function loadParticipants() {
    $('#participantsModalMessage').text('');
    $('#participantsModalBody').html('<tr><td colspan="4" class="text-center">Cargando participantes...</td></tr>');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        url: "/random-participants",
        dataType: "json",
    }).done(function (data) {
        if (!Array.isArray(data)) {
            $('#participantsModalBody').html('<tr><td colspan="4" class="text-center text-danger">La respuesta no contiene participantes.</td></tr>');
            return;
        }

        data.sort(function (a, b) {
            let statusA = Number(a.status) === 2 ? 0 : 1;
            let statusB = Number(b.status) === 2 ? 0 : 1;

            if (statusA !== statusB) {
                return statusA - statusB;
            }

            return String(a.nombres_apellidos || '').localeCompare(String(b.nombres_apellidos || ''));
        });

        if (!data.length) {
            $('#participantsModalBody').html('<tr><td colspan="4" class="text-center">No hay participantes registrados.</td></tr>');
            return;
        }

        let rows = '';

        $.each(data, function (index, participant) {
            rows += `
                <tr data-id="${participant.id}">
                    <td>${participant.nombres_apellidos ?? ''}</td>
                    <td>${formatDateValue(participant.updated_at)}</td>
                    <td class="status-cell">
                        <span class="participant-status-label ${Number(participant.status) === 2 ? 'status-selected' : 'status-active'}">
                            ${Number(participant.status) === 2 ? 'Seleccionado' : 'Activo'}
                        </span>
                    </td>
                    <td class="action-cell">
                        <label class="participant-switch">
                            <input type="checkbox" class="participant-toggle" data-id="${participant.id}" ${Number(participant.status) === 2 ? 'checked' : ''}>
                            <span class="participant-slider"></span>
                        </label>
                    </td>
                </tr>
            `;
        });

        $('#participantsModalBody').html(rows);
    }).fail(function () {
        $('#participantsModalBody').html('<tr><td colspan="4" class="text-center text-danger">No fue posible cargar los participantes.</td></tr>');
    });
}

function updateParticipantStatus(participantId, status, $row, $toggle) {
    let previousStatus = status === 2 ? 1 : 2;

    $row.addClass('is-saving');
    $toggle.prop('disabled', true);
    $('#participantsModalMessage').text('Actualizando estado...');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "/random-participants/update-status",
        dataType: "json",
        data: {
            id: participantId,
            status: status
        },
    }).done(function (response) {
        $('#participantsModalMessage').text(response.message || 'Estado actualizado.');

        let rowStatus = Number(response.participante && response.participante.status ? response.participante.status : status);
        let rowDate = response.participante && response.participante.updated_at ? response.participante.updated_at : null;

        $row.find('.participant-status-label')
            .text(rowStatus === 2 ? 'Seleccionado' : 'Activo')
            .toggleClass('status-selected', rowStatus === 2)
            .toggleClass('status-active', rowStatus !== 2);

        $row.find('td:nth-child(2)').text(formatDateValue(rowDate));
        countuser();
    }).fail(function (xhr) {
        let message = 'No fue posible guardar los cambios.';

        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        $('#participantsModalMessage').text(message);
        $toggle.prop('checked', previousStatus === 2);
    }).always(function () {
        $toggle.prop('disabled', false);
        $row.removeClass('is-saving');
    });
}

function formatDateValue(value) {
    if (!value) {
        return 'Sin actualizar';
    }

    let parsed = new Date(value);

    if (isNaN(parsed.getTime())) {
        return value;
    }

    return parsed.toLocaleString('es-CO', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function countuser() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        url: "/countuser",
        data: "data",
        dataType: "json",
        success: function (data) {
            $('#user').html(data);
        }
    });
}
