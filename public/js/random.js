/*
Author: FREDDY JR MENDOZA PADILLA
Date: 21/06/2024
Description: Script para seleccionar un participante al azar, disparar confeti y administrar estados.
*/

$(document).ready(function () {
    countuser();
    bindParticipantsCrudModal();
    $('#participantsCrudForm').on('submit', saveParticipant);
    $('#crudCancelEdit').on('click', clearCrudForm);
    $('#participantCrudSearch').on('input', filterCrudParticipants);
    $('#toggleCreateParticipantSection').on('click', toggleCreateParticipantSection);

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

let participantsCrudCache = [];

function bindParticipantsCrudModal() {
    $('#openParticipantsCrudModal').on('click', function (e) {
        e.preventDefault();
        openParticipantsCrudModal();
    });

    $(document).on('change', '.participant-status-toggle', function () {
        let $toggle = $(this);
        let $row = $toggle.closest('tr');
        let participantId = $toggle.data('id');
        let nextStatus = $toggle.is(':checked') ? 2 : 1;

        saveInlineParticipant($row, {
            id: participantId,
            nombres_apellidos: $row.find('.participant-name-inline').val(),
            status: nextStatus
        }, $toggle);
    });

    $(document).on('blur', '.participant-name-inline', function () {
        saveInlineName($(this));
    });

    $(document).on('keydown', '.participant-name-inline', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).blur();
        }
    });

    $(document).on('click', '.participant-delete', function () {
        let $button = $(this);
        let $row = $button.closest('tr');
        let participantName = $row.find('.participant-name-inline').val() || 'este participante';
        let participantId = $button.data('id');

        if (!participantId) {
            return;
        }

        if (!window.confirm(`Seguro que deseas eliminar a ${participantName}?`)) {
            return;
        }

        deleteParticipant(participantId, $row);
    });
}

function openParticipantsCrudModal() {
    clearCrudForm();
    loadCrudParticipants();
    $('#participantsCrudModal').modal('show');
}

function loadCrudParticipants() {
    $('#participantsCrudModalMessage').text('Cargando participantes...');
    $('#participantsCrudModalBody').html('<tr><td colspan="4" class="text-center">Cargando participantes...</td></tr>');

    return $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        url: "/random-participants",
        dataType: "json",
    }).done(function (data) {
        participantsCrudCache = Array.isArray(data) ? sortParticipants(data.slice()) : [];
        renderCrudParticipants(participantsCrudCache);
        filterCrudParticipants();
        $('#participantsCrudModalMessage').text('');
    }).fail(function () {
        $('#participantsCrudModalBody').html('<tr><td colspan="4" class="text-center text-danger">No fue posible cargar los participantes.</td></tr>');
        $('#participantsCrudModalMessage').text('No fue posible cargar los participantes.');
    });
}

function renderCrudParticipants(participants) {
    if (!participants.length) {
        $('#participantsCrudModalBody').html('<tr id="participantsCrudEmptyState"><td colspan="5" class="text-center">No hay participantes registrados.</td></tr>');
        return;
    }

    let rows = '';

    $.each(participants, function (index, participant) {
        let status = Number(participant.status) === 2 ? 2 : 1;
        let name = participant.nombres_apellidos || '';

        rows += `
            <tr data-id="${participant.id}" data-search="${escapeHtmlAttribute((name + ' ' + (status === 2 ? 'seleccionado' : 'activo')).toLowerCase())}">
                <td>
                    <input type="text" class="form-control input-sm participant-name-inline" data-id="${participant.id}" value="${escapeHtmlAttribute(name)}" data-original-value="${escapeHtmlAttribute(name)}" maxlength="255">
                    <div class="participant-inline-message" data-inline-message="${participant.id}"></div>
                </td>
                <td class="participant-updated-at">${formatDateValue(participant.updated_at)}</td>
                <td class="status-label-cell">
                    <span class="participant-status-label ${status === 2 ? 'status-selected' : 'status-active'}">
                        ${status === 2 ? 'Seleccionado' : 'Activo'}
                    </span>
                </td>
                <td class="status-toggle-cell">
                    <label class="participant-switch">
                        <input type="checkbox" class="participant-status-toggle" data-id="${participant.id}" ${status === 2 ? 'checked' : ''}>
                        <span class="participant-slider"></span>
                    </label>
                </td>
                <td class="action-cell action-buttons">
                    <button type="button" class="btn btn-xs btn-danger participant-delete" data-id="${participant.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    rows += '<tr id="participantsCrudEmptyState" class="participant-row-hidden"><td colspan="5" class="text-center">No se encontraron resultados.</td></tr>';

    $('#participantsCrudModalBody').html(rows);
}

function filterCrudParticipants() {
    let query = normalizeSearch($('#participantCrudSearch').val());
    let visibleCount = 0;

    $('#participantsCrudModalBody tr[data-id]').each(function () {
        let $row = $(this);
        let rowText = normalizeSearch($row.attr('data-search'));
        let matches = !query || rowText.indexOf(query) !== -1;

        $row.toggle(matches);

        if (matches) {
            visibleCount++;
        }
    });

    let $empty = $('#participantsCrudEmptyState');
    if ($empty.length) {
        if (participantsCrudCache.length === 0) {
            $empty.removeClass('participant-row-hidden').show().find('td').text('No hay participantes registrados.');
        } else if (visibleCount === 0) {
            $empty.removeClass('participant-row-hidden').show().find('td').text('No se encontraron resultados.');
        } else {
            $empty.addClass('participant-row-hidden').hide();
        }
    }
}

function saveParticipant(event) {
    event.preventDefault();

    let name = $('#participantCrudName').val();

    if (!name || !name.trim()) {
        $('#participantsCrudModalMessage').text('El nombre del participante es obligatorio.');
        $('#participantCrudName').focus();
        return;
    }

    $('#participantsCrudModalMessage').text('Guardando participante...');
    $('#saveParticipantBtn').prop('disabled', true);

    persistParticipant({
        nombres_apellidos: name,
        status: 1
    }).done(function (response) {
        clearCrudForm(false);
        loadCrudParticipants().done(function () {
            $('#participantsCrudModalMessage').text(response.message || 'Participante creado correctamente.');
        });
        countuser();
    }).fail(function (xhr) {
        let message = 'No fue posible guardar el participante.';

        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        $('#participantsCrudModalMessage').text(message);
    }).always(function () {
        $('#saveParticipantBtn').prop('disabled', false);
    });
}

function saveInlineName($input) {
    let $row = $input.closest('tr');
    let participantId = $input.data('id');
    let name = ($input.val() || '').trim();
    let originalName = ($input.data('original-value') || '').trim();

    if (!participantId || name === originalName) {
        return;
    }

    if (!name) {
        $input.val(originalName);
        setInlineMessage($row, 'El nombre no puede quedar vacio.');
        return;
    }

    saveInlineParticipant($row, {
        id: participantId,
        nombres_apellidos: name,
        status: getRowStatus($row)
    }, null);
}

function saveInlineParticipant($row, payload, $control) {
    let participantId = payload.id;
    let $input = $row.find('.participant-name-inline');
    let previousName = $input.data('original-value') || '';
    let previousStatus = getRowStatus($row);

    $row.addClass('participant-row-saving');
    setInlineMessage($row, 'Guardando...');

    if ($control) {
        $control.prop('disabled', true);
    }

    persistParticipant(payload).done(function (response) {
        let participant = response.participante || {
            id: participantId,
            nombres_apellidos: payload.nombres_apellidos,
            status: payload.status
        };

        syncCrudCacheParticipant(participant);
        updateCrudRow($row, participant);
        filterCrudParticipants();
        setInlineMessage($row, response.message || 'Actualizado.');
        countuser();
    }).fail(function (xhr) {
        let message = 'No fue posible guardar los cambios.';

        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        $input.val(previousName);
        setInlineMessage($row, message);

        if ($control && $control.hasClass('participant-status-toggle')) {
            $control.prop('checked', previousStatus === 2);
        }
    }).always(function () {
        if ($control) {
            $control.prop('disabled', false);
        }

        $row.removeClass('participant-row-saving');
    });
}

function deleteParticipant(participantId, $row) {
    let $messageRow = $row.find('[data-inline-message="' + participantId + '"]');

    $row.addClass('participant-row-saving');
    setInlineMessage($row, 'Eliminando...');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "/random-participants/delete",
        dataType: "json",
        data: {
            id: participantId
        },
    }).done(function (response) {
        removeCrudCacheParticipant(participantId);
        $row.remove();
        filterCrudParticipants();
        countuser();
        $('#participantsCrudModalMessage').text(response.message || 'Participante eliminado.');
    }).fail(function (xhr) {
        let message = 'No fue posible eliminar el participante.';

        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        setInlineMessage($row, message);
    }).always(function () {
        $row.removeClass('participant-row-saving');
    });
}

function clearCrudForm(resetMessage) {
    let form = $('#participantsCrudForm')[0];

    if (form) {
        form.reset();
    }

    $('#participantCrudId').val('');
    $('#saveParticipantBtn').html('<i class="fas fa-save"></i> Guardar');
    $('#participantCrudSearch').val('');
    filterCrudParticipants();
    collapseCreateParticipantSection();

    if (resetMessage !== false) {
        $('#participantsCrudModalMessage').text('');
    }
}

function toggleCreateParticipantSection() {
    let $panel = $('.create-participant-panel');
    let isCollapsed = $panel.hasClass('is-collapsed');

    $panel.toggleClass('is-collapsed', !isCollapsed);
    $('#toggleCreateParticipantSection')
        .attr('aria-expanded', String(isCollapsed))
        .find('.create-section-chevron')
        .toggleClass('fa-chevron-down', isCollapsed)
        .toggleClass('fa-chevron-right', !isCollapsed);
}

function collapseCreateParticipantSection() {
    let $panel = $('.create-participant-panel');

    $panel.addClass('is-collapsed');
    $('#toggleCreateParticipantSection')
        .attr('aria-expanded', 'false')
        .find('.create-section-chevron')
        .removeClass('fa-chevron-down')
        .addClass('fa-chevron-right');
}

function persistParticipant(payload) {
    return $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "/random-participants/save",
        dataType: "json",
        data: payload,
    });
}

function updateCrudRow($row, participant) {
    let status = Number(participant.status) === 2 ? 2 : 1;
    let name = participant.nombres_apellidos || '';

    $row.attr('data-search', (name + ' ' + (status === 2 ? 'seleccionado' : 'activo')).toLowerCase());
    $row.find('.participant-name-inline')
        .val(name)
        .data('original-value', name);
    $row.find('.participant-updated-at').text(formatDateValue(participant.updated_at));
    $row.find('.participant-status-toggle').prop('checked', status === 2);
    $row.find('.participant-status-label')
        .text(status === 2 ? 'Seleccionado' : 'Activo')
        .toggleClass('status-selected', status === 2)
        .toggleClass('status-active', status !== 2);
}

function syncCrudCacheParticipant(participant) {
    let index = participantsCrudCache.findIndex(function (item) {
        return Number(item.id) === Number(participant.id);
    });

    if (index === -1) {
        participantsCrudCache.push(participant);
    } else {
        participantsCrudCache[index] = Object.assign({}, participantsCrudCache[index], participant);
    }

    participantsCrudCache = sortParticipants(participantsCrudCache);
}

function removeCrudCacheParticipant(participantId) {
    participantsCrudCache = participantsCrudCache.filter(function (item) {
        return Number(item.id) !== Number(participantId);
    });
}

function setInlineMessage($row, message) {
    let participantId = $row.data('id');
    $row.find('[data-inline-message="' + participantId + '"]').text(message || '');
}

function getRowStatus($row) {
    return $row.find('.participant-status-toggle').is(':checked') ? 2 : 1;
}

function sortParticipants(participants) {
    return participants.sort(function (a, b) {
        let statusA = Number(a.status) === 2 ? 0 : 1;
        let statusB = Number(b.status) === 2 ? 0 : 1;

        if (statusA !== statusB) {
            return statusA - statusB;
        }

        if (statusA === 0) {
            let dateA = new Date(a.updated_at || 0).getTime();
            let dateB = new Date(b.updated_at || 0).getTime();

            if (dateA !== dateB) {
                return dateB - dateA;
            }
        }

        return String(a.nombres_apellidos || '').localeCompare(String(b.nombres_apellidos || ''));
    });
}

function normalizeSearch(value) {
    return String(value || '').trim().toLowerCase();
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

function escapeHtmlAttribute(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function escapeHtmlText(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
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
